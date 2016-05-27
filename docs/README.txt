Used frameworks :

This application uses PHP framework CodeIgnitor 3.0.6 and CSS framework Bootstrap 3.3.6

Application Description :

We have a council who would like to use an application to queue people at the reception
desk. The receptionist should be able to select the service (example provided below) and
take the customer details depending on the customer type:

• Citizen: title, first name and last name fields should be displayed
• Organisation: organisation name field should be visible
• Anonymous: no input fields should be visible


List of Services :

Path to service list can be changed/updated in /application/config/config
the default filepath is :

$config['service_list_path'] = APPPATH . '../service/service.json';


Customers Data :

This application stores the customers data unless you removed it within application or you do it manually.
This path can be also changed in /application/config/config :

$config['file_storage_path'] = APPPATH . '../data/';