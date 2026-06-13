# Azure Deployment Guide

This document describes how to get the Azure deployment of this project up and running on a linux host machine.

## Prerequisites

> To manage dependencies and avoid conflicts with system packages, it is a good idea to use a virtual environment for Python dependencies when working with Ansible and Azure SDKs.

Installed on host machine:
- Python 3 installed: `python3 --version` >=3.14.4
- Azure CLI installed: `az --version` >= 2.87.0
- CLI logged into an azure subscription with appropriate permissions to create resources.

Installed in virtual environment:
- Pip installed: `pip --version` >= 25.1.1
- Ansible installed: `pip install ansible`  >= 2.21.0
- Azure Python SDK: `pip install azure` >= 5.0.0
- Ansible Azure collection: `ansible-galaxy collection install azure.azcollection`

## Handling Dependencies
When running the ansible playbooks, there might be errors related to missing dependencies for the azure collection modules. If you encounter such errors, you can find the required dependencies in the `requirements.txt` file. Make sure your virtual environment is activated, locate the file at:

`./venv/lib/<your_python_version>/site-packages/ansible_collections/azure/azcollection/`

Then, install the required dependencies using pip:

```bash
pip install -r requirements.txt
```

## Secrets

Adapt the `env_azure` file in the root directory of the project with your actual configuration. Rename it to `azure.env` - which is included in the `.gitignore` file to prevent accidental commits.

Load the environment variables from the `azure.env` file before running the Ansible playbooks:

```bash
source azure.env
```

## Running the Ansible Playbooks

### Deployment

To deploy the infrastructure on Azure, run the following command from the root directory of the project:

```bash
ansible-playbook site.yml --tag provision
```
This command will execute the Ansible playbook and provision the necessary resources on Azure as defined in the `site.yml` playbook. Make sure to review the playbook and adjust any parameters or configurations as needed for your specific deployment requirements.

> In a new Azure subscription, you might need to register the required resource providers before running the playbook. You can do this using the Azure CLI with the following command (or directly in the Azure portal):

```bash
az provider register --namespace Microsoft.Compute --subscription <SUBSCRIPTION_ID>
```

```bash
az provider register --namespace Microsoft.Network --subscription <SUBSCRIPTION_ID>
```
After the deployment is complete, you can verify that the resources have been created successfully by checking the Azure portal or using the Azure CLI. For example, to list the virtual machines created in a specific resource group, you can use:

```bash
az vm list --resource-group <RESOURCE_GROUP_NAME> --output table
```

### Teardown

To tear down the infrastructure and remove the resources from Azure, run the following command:

```bash
ansible-playbook site.yml --tag teardown
```

This command will execute the Ansible playbook and delete the resources that were provisioned on Azure. Make sure to review the playbook and confirm that you want to delete the resources, as this action is irreversible and will result in the loss of any data stored in those resources. After the teardown is complete, you can verify that the resources have been deleted successfully by checking the Azure portal or using the Azure CLI. For example, to check if the resource group has been deleted, you can use:

```bash
az group show --name <RESOURCE_GROUP_NAME>
```