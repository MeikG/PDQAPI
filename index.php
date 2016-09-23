<?php

// Require our bootstrap file.
require_once('lib/bootstrap.php');

$app = new Slim\App();

// Return information about a specific computer.
$app->get('/computer/{hostname}[/{option}]', function ($request, $response, $args) {
    global $db;
    $hostname = strtoupper($args['hostname']);

    $return = [];
    $PC = $db->inventory->select('Computers', ['ComputerId', 'Manufacturer', 'Model', 'OSName(LocalWin)', 'SerialNumber', 'ProcessorSummary(Processor)', 'ADPath', 'MacAddress', 'IPAddress(IPAddr)', 'IsOnline', 'CurrentUser', 'SuccessfulScanDate', 'ScanStatus'], ['Name' => $hostname])[0];

    switch ($args['option']) {
        case '':
            $return = $PC;
            break;
        case 'deployments':
            $deployments = $db->deploy->select('DeploymentComputers', ['[>]Deployments' => 'DeploymentId'], ['DeploymentId', 'PackageId', 'PackageName', 'Created', 'Status', 'Error', 'Stage'], ['ShortName' => $hostname, "ORDER" => "Created DESC"]);
            $return['Count'] = count($deployments);
            $return['Deployments'] = $deployments;
            break;
        case 'software':
            $return = $db->inventory->select('Applications', ['Name', 'Publisher', 'Version', 'InstallDate'], ['ComputerId' => (int)$PC['ComputerId'], "ORDER" => "Name ASC"]);
            break;
        default:
            $return = ['Error' => 'Malformed request.'];
            $response = $response->withStatus(501);
            break;
    }
    if (! $return) {
        // If there's no info, the PC doesn't exist with PDQ. So fail pretty.
        $return = ['Error' => 'Cannot find information about this computer within PDQ. The hostname attribute might be missing or incorrect.'];
        $response = $response->withStatus(404);
    }

    $response = $response->withJson($return);
    return $response;
});

$app->run();
