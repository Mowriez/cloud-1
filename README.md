# Cloud-1 Project Documentation
---
## 1. Prerequisites & Local Environment Setup
### Infrastructure & Cloud Provisioning
- An Azure account with appropriate permissions to create resources.
- Azure CLI installed and configured on your local machine (`az login`).
- An Azure Service Principal created for authentication (you can create one using the Azure CLI).
- The `azure.env` file should be created with the necessary environment variables for Azure authentication.
### Local Environment Configuration

- Make sure you have `ansible` and `ansible-galaxy` installed on your machine

	This project relies on external modules to manage system users, SSH authorization, and firewall configurations. Install the required collections by running the following commands in your terminal:

	```bash
	ansible-galaxy collection install community.general

	ansible-galaxy collection install ansible.posix --force
	ansible-galaxy collection install azure.azcollection
	pip install azure
	```

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