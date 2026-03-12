
## Project setup

The project includes an automated setup script that bootstraps the entire environment.

### Start the project and initialize everything

```bash
./setup.sh
`````

### Create admin user
Open your browser and go to the registration page:
http://localhost/admin/register  
This account will not have any admin privileges.  
To make it a SuperAdmin, use the command in the next step.
```bash
# Make SuperAdmin 
./vendor/bin/sail artisan make:superadmin {email}
