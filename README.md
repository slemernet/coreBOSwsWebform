coreBOS Webservice Webform
================

**coreBOS advanced webform creation and validation**

This project takes webforms to the next level. coreBOS has a native webform creation and implementation feature that permits us to create a webform for a given module (accounts, contacts, leads, potentials, helpdesk,...) but in many cases, somebody filling in information on our website isn't just one entity in coreBOS. For example, somebody filling in a contact form may already be interested in some product and should be converted into a Contact **AND** an Opportunity, or when filling in a support form we should get a Contact **AND** a HelpDesk. That is what this project does, it is an easy way to convert fields captured from our webform into different entities in coreBOS.

While we were at it we added the **typical validation of fields**, so you can make sure a given field is not repeated or already exists before sending the information in to the application.

How to use:
After we clone the repository:
The coreBOSwsWebform uses WSClient.php to connect to your corebos.
We download that from coreBOSwsLibrary repository https://github.com/tsolucio/coreBOSwsLibrary.git
From the library we want the php one.
We clone that directory to our coreBOSwsWebform.
Move the php dir to cbwsclib in order to use it in our WSWebform.php.
The test.php defines some configuration data about what we want the webservice to do, including the URL, user, password, and field mappings for the Contacts module.
The cbwswebform.html is a simple web form with input fields including first name, last name, email address, description, potential_name and potential_closingdate. In the form element we configure the action to specify the URL of the script or page that will process the form data, which would be http://localhost/your_dir_name/test.php or to your configured WSWebform.php.
In the test.php $defaults array we configure:
url - your corebos url
user - your username
password - your password
Fill in the cbwswebform.html form, submit and you should see the entities in your coreBOS.

You can find full information on the functionality and configuration on the [project's wiki page](http://corebos.org/documentation/doku.php?id=en:extensions:coreboswswebform).



*coreBOS Team*
