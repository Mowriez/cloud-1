# Cloud-1 Project Documentation

## Prerequisites

> To manage dependencies and avoid conflicts with system packages, it is a good idea to use a virtual environment for Python dependencies when working with Ansible and Azure SDKs.

Installed on host machine:
- Python 3 installed: `python3 --version` >=3.14.4
- Azure CLI installed: `az --version` >= 2.87.0
- CLI logged into an azure subscription with appropriate permissions to create resources.

Installed in virtual environment:
- Pip installed: `pip --version` >= 25.1.1
- Ansible installed: `pip install ansible`  >= 2.21.0
- Ansible Galaxy CLI installed: `pip install ansible-galaxy` >= 2.21.0
- Azure Python SDK: `pip install azure` >= 5.0.0
- The following collections: 
    - `ansible-galaxy collection install azure.azcollection`
    - `ansible-galaxy collection install --force ansible.posix`
    - `ansible-galaxy collection install community.general`


## Azure Deployment Guide

The following describes how to get the Azure deployment of this project up and running on a linux host machine.

### Handling Dependencies
When running the ansible playbooks, there might be errors related to missing dependencies for the azure collection modules. If you encounter such errors, you can find the required dependencies in the `requirements.txt` file. Make sure your virtual environment is activated, locate the file at:

`./venv/lib/<your_python_version>/site-packages/ansible_collections/azure/azcollection/`

Then, install the required dependencies using pip:

```bash
pip install -r requirements.txt
```

### Secrets

Adapt the `group_vars/all.yml` file with your actual configuration. 

Load the environment variables from the `azure.env` file before running the Ansible playbooks:

### Running the Ansible Playbooks

#### Deployment

To provision the infrastructure on Azure, run the following command from the root directory of the project:

```bash
ansible-playbook provision.yml
```
Make sure to review the playbook and adjust any parameters or configurations as needed for your specific deployment requirements.

> In a new Azure subscription, you might need to register the required resource providers (Microsoft.Compute, Microsoft.Network) before running the playbook. You can do this using the Azure CLI with the following command (or directly in the Azure portal):

```bash
az provider register --namespace Microsoft.Compute --subscription <SUBSCRIPTION_ID>
```

After the deployment is complete, you can verify that the resources have been created successfully by checking the Azure portal or using the Azure CLI. For example, to list the virtual machines created in a specific resource group, you can use:

```bash
az vm list --resource-group <RESOURCE_GROUP_NAME> --output table
```

#### Teardown

To tear down the infrastructure and remove the resources from Azure, run the following command:

```bash
ansible-playbook teardown.yml
```

This command will execute the Ansible playbook and delete the resources that were provisioned on Azure. Make sure to review the playbook and confirm that you want to delete the resources, as this action is irreversible and will result in the loss of any data stored in those resources. After the teardown is complete, verify that the resources have been deleted successfully by checking the Azure portal or using the Azure CLI. For example, to check if the resource group has been deleted, you can use:

```bash
az group show --name <RESOURCE_GROUP_NAME>
```

### Local Environment Configuration

- Environment Variables Configuration
	The playbooks dynamically read configurations from a local environment file.

	In the project root directory, copy the provided example file to create your active environment configuration:
   ```bash
   cp .env_example .env
   ```
   Open the newly created `.env` file and define your target deployment username:
   ```ini
   target_deploy_user=your_custom_username
   ```

- **Ansible Vault Access (Shared Secrets & Certificates)**
  Core infrastructure credentials and SSL certificates that must match across deployments are securely encrypted inside the repository. To allow Ansible to decrypt them automatically, you must create a local password file.

  In your project root directory, create the password file and populate it with the master key provided by your peers:
  ```bash
  echo "your_vault_password_here" > .vault_pass
  ```

- Create an `inventory.yml` in the `inventory/` folder. Populate it with your cloud target IPs
	```
	all:
	  hosts:
	    cloud-1:
	      ansible_host: 10.12.2.6
	    cloud-2:
	      ansible_host: 10.12.2.7
	    cloud-3:
	      ansible_host: 10.12.2.8
	```
> **Execution Directory Tip:** If you choose to run commands from a different folder, you must explicitly append `-i [path/to/your/inventory.yml]` to your execution string, or override the default pathing inside an `ansible.cfg` file.

## 2. First Run on a Freshly Provisioned Server
Because a freshly provisioned cloud instance only has the provider's default administrative user, you must run the bootstrap playbook **once** to create your secure deployment user and authorize your local SSH key that you provide in your `.env`. <br>
`ansible-playbook first_setup.yml -u [server-user] -k -K`
- Replace `[server-user]` with the default administration username provided by your cloud host (e.g., ubuntu, debian, root).
- `-k`: Prompts you for the default user's initial SSH password.
- `-K`: Prompts you for the root/sudo password so Ansible has permissions to create the new account.

## 3. Deploy docker
After that you can run <br>
`ansible-playbook main.yml`
<br>
This command will run the roles in this order:
- docker
	- install docker
- ufw
	- install ufw firewall and configure port settings (http, https, ssh)
- wordpress_containers
	- copy to server docker-compose, Dockerfile, nginx and https certificates
	- build and bring up docker containers