MasterDomainList.php
---------------------
source file used to generate the domain list, this list needs to be manually kept up to date.


DomainList.php
---------------------
automatically generated output list based on MasterdomainList.php, this is the list of domains users will see.


/maintenance/updateEmailDomains.php
-------------------------------------
maintenance script which should be run on a regular basis.  It automatically 
updates the DomainList.php array based on the number of emails currently in 
use in GCPEDIA. To change the threshold modify the following line:

define("MIN_COUNT",	40);


old-lists/
-------------
folder where old lists are archived incase an update fails and the previous list needs to be restored.
					