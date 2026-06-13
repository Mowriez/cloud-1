# cloud-1
School 42 advanced core project

## Prerequisites for Azure deployment

### Cloud Infrastructure and Ansible

- An Azure account with appropriate permissions to create resources.
- Azure CLI installed and logged in on the host machine.
- Additional packages: python3, pip, and Ansible installed on the host machine.

- Ansible should be run in a virtual environment to manage dependencies. You can create and activate a virtual environment using the following commands:

```bash
python3 -m venv venv
source venv/bin/activate
```


### Secrets

- The `azure.env` file should be created with the necessary environment variables for Azure authentication.

- Ansible azure collection installed (you can install it using `nsible-galaxy collection install azure.azcollection`).

- Azure Python library installed (you can install it using `pip install azure`).

requirements.txt!!!!