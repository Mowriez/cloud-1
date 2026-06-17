# Cloud-1

WordPress Cloud Infrastructure Deployment 

An automated infrastructure-as-code solution designed to provision and deploy a WordPress stack inside a Dockerized cloud environment. 

This project uses **Ansible** for infrastructure provisioning and automated server configuration and **Docker Compose** to orchestrate the application layers, featuring custom Nginx reverse proxying, SSL handling, and integrated database management.

## Tech Stack

* **Automation:** Ansible (Playbooks, Vault, and Roles)
* **Containerization:** Docker & Docker Compose
* **Web Server:** Nginx (Configured for HTTPS/TLS termination)
* **Application:** WordPress
* **Database & Tools:** MySQL  & phpMyAdmin


## Architecture Overview

The deployment configures a secure network isolated from the public internet, exposing only the essential ports via Nginx:

* **Port 80/443:** Open to the web via Nginx (with automatic HTTP to HTTPS redirection).
* **WordPress Core:** Runs via FastCGI behind Nginx.
* **`/phpmyadmin` Path:** Safely reverse-proxied over the internal Docker network straight to the database dashboard.
* **MySQL Database:** Completely isolated; accessible only internally by WordPress and phpMyAdmin.

##  How To Run It

Extensive documentation and a step-by-step guide is available in the `/docs` - directory.

---

This is a 42 Wolfsburg Advanced Core Project completed by atamas&mtrautne
