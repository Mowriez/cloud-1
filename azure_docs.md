# Azure Deployment Guide

This document describes how to get the Azure deployment of this project up and running on a linux host machine.

## Prerequisites

Note: To manage dependencies and avoid conflicts with system packages, it is a good idea to use a virtual environment for Python dependencies when working with Ansible and Azure SDKs.

Installed on host machine:
- Azure subscription
- Azure CLI installed: `az --version`

Installed in virtual environment:
- Ansible installed: `ansible --version`
- Python 3 installed: `python3 --version`
- Pip installed: `pip --version`
- Ansible Azure collection: `ansible-galaxy collection install azure.azcollection`
- Azure Python SDK: `pip install azure`


#