```
Please note that this is only a sample of the code.
```

# PDQ API
Stateless RESTful API for PDQ Deploy & PDQ Inventory.<br>
Please be aware that this API is designed to be used in an internal environment only, and as such does not have authentication. It also requires use of the command prompt, which inherently makes it less secure. Use at your own risk!

## Installation
Install the composer files, and host on your favourite PHP webserver.

## Routes
```
GET /computer/{hostname}
```
Retrieves common information about the computer. Can also pull information about deployments with /deployments, and software with /software.

```
GET /software
```
Retrieve all software from the root of PDQ Deploy. Folders relative to the root can be appended e.g. /foo/bar.

```
GET /package/{name}
```
Retrieve information about a specific package within PDQ.

```
POST /computer/{hostname}/deploy/{package}
```
Deploy a specific package to a computer.

```
POST /computer/{hostname}/wake
```
Wake a computer using WoL.

```
POST /computer/{hostname}/scan
```
Request a computer be scanned by PDQ Inventory.

```
GET /bundle
```
Request a list of all software bundles.
