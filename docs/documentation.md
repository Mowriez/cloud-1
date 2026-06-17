# Cloud-1 Project Documentation

## 0 - Prerequisites

### Software dependencies
> To manage dependencies and avoid conflicts with system packages, it is a good idea to use a virtual environment for Python dependencies when working with Ansible and Azure SDKs.

Installed on host machine:
- Python 3 installed: `python3 --version` >=3.14.4
- Azure CLI installed: `az --version` >= 2.87.0
- CLI logged into an azure subscription with appropriate permissions to create resources.

Installed in virtual environment (`python3 -m venv .venv` -> `. .venv/bin/activate`):
- Pip installed: `pip --version` >= 25.1.1
- Ansible installed: `pip install ansible`  >= 2.21.0
- Ansible Galaxy CLI installed: `ansible-galaxy collection list`
- The following collections: 
    - `ansible-galaxy collection install azure.azcollection`
    - `ansible-galaxy collection install --force ansible.posix`
    - `ansible-galaxy collection install community.general`

### User-specific variables and credentials

The Ansible playbooks refer to `group_vars/all.yml` as a unified source for all user-specific parameters and secrets.
Adapt the `group_vars/all.yml.example` file with your actual configuration and rename it to `all.yml`.

### Ansible Vault

SSL certificates that must match across deployments are securely encrypted inside the repository. To allow Ansible to decrypt them automatically, you must create a local password file.

In your project root directory, create the password file and populate it with the master key provided by your peers:
```bash
echo 'your_vault_password_here' > .vault_pass
```

If you are not a member of the original team that created this repository, you  will have no acces to this key and must provide your own certificates in `/roles/wordpress_containers/files/certs`

## 1 - Azure Provisioning Guide

The following describes how to get the neccessary azure resources of this project up and running.

### Handling Dependencies
When running the Ansible playbooks, there might be errors related to missing dependencies for the azure collection modules. If you encounter such errors, you can find the required dependencies in the `requirements.txt` file. Make sure your virtual environment is activated, locate the file at:

`[./venv/lib/<your_python_version>/site-packages/ansible_collections/azure/azcollection/]`

Then, install the required dependencies using pip:

```bash
pip install -r requirements.txt
```

### Running the Ansible Playbooks

> **Execution Directory Tip:** If you choose to run commands from a different folder, you must explicitly append `-i [path/to/your/inventory.yml]` to your execution string, or override the default pathing inside an `ansible.cfg` file.

- **Provisioning**

    To provision the infrastructure on Azure, run the following command from the root directory of the project:

    ```bash
    ansible-playbook provision.yml
    ```
    Make sure to review the playbook and adjust any parameters or configurations as needed for your specific deployment requirements.

    In a new Azure subscription, you might need to register the required resource providers (Microsoft.Compute, Microsoft.Network) before running the playbook. You can do this using the Azure CLI with the following command (or directly in the Azure portal):

    ```bash
    az provider register --namespace Microsoft.Compute --subscription <SUBSCRIPTION_ID>
    ```

    After the deployment is complete, you can verify that the resources have been created successfully by checking the Azure portal or using the Azure CLI. For example, to list the virtual machines created in a specific resource group, you can use:

    ```bash
    az vm list --resource-group <RESOURCE_GROUP_NAME> --output table
    ```

- **Teardown**

    To tear down the infrastructure and remove the resources from Azure, run the following command:

    ```bash
    ansible-playbook teardown.yml
    ```
    Make sure to confirm that you actually want to delete the resources, as this action is irreversible and will result in the loss of any data stored on them.

    After the teardown is complete, verify that the resources have been deleted successfully by checking the Azure portal or using the Azure CLI. For example, to check if the resource group has been deleted, you can use:

    ```bash
    az group show --name <RESOURCE_GROUP_NAME>
    ```

## 2 - Webserver Deployment Guide

The provisioning and deployment steps are purposefully separated in this project to give you a step-by-step experience which lets you investigate individual resources and make sure they have executed to your satisfaction.

To run the deployment of the services to the VM you created in step 1,  copy the IP provided in the terminal output of the last play in the `provision.yml` run and add it as the `ansible_host_1` parameter in `group_vars/all.yml`

After that you can run 

```bash
ansible-playbook deploy.yml
```

This command will run the deployment roles in this order:
- docker
	- install docker
- ufw
	- install ufw firewall and configure port settings (http, https, ssh)
- wordpress_containers
	- copy to server docker-compose, Dockerfile, nginx and https certificates
	- build and bring up docker containers

After the process is finished you can reach the webserver by connecting to the IP specified above in a webbrowser of your choice. By default a small frontpage with the names of the creators of this project will be rendered. If you want to access wordpress, connect to the `/wp-admin` - path. 

phpMyAdmin is accessible at `/phpmyadmin`. 

You can login to both services with the credentials you provided in `/group_vars/all.yml`.