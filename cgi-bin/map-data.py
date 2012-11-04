#!/usr/bin/python
"""\
CGI script to print CSV data of services & organizations helping a given disaster.

Requires PyMySQL and Python 2.7. PyMySQL may be found at http://www.pymysql.org/.
It is assumed that PyMySQL is in the directory inserted into the Python path
in the `sys.path.insert` line below.

The disaster to be selected from the database should be selected by appending
`?disaster=#` to the URL of this script. `#` should be an integer key into the
database of disasters. (This is done for security -- it's hard to do a SQL
injection attack with just an integer.)

If the disaster ID is not recognized, "Missing disaster id" is written and the
script exits with exit code 1.
"""

from csv import writer as csvwriter
import sys
import cgi
import cgitb

sys.path.insert(0, '/home5/disastg1/python/lib/python2.7/site-packages/')
import pymysql

cgitb.enable()
print "Content-Type: text/csv\n"

cgienv = cgi.FieldStorage()
try:
    disaster_id = int(cgienv['disaster'].value)
except (KeyError, ValueError):
    print "Missing disaster id"
    sys.exit(1)

conn = pymysql.connect(host='localhost', port=3306, user='disastg1_dapuser',
                       passwd='1q2w3e4r', db='disastg1_dap')
cursor = conn.cursor()
cursor.execute("""SELECT `T2`.`name_organization`,
                         `T2`.`id`,
                         `T3`.`name_service`,
                         `T3`.`id`,
                         `T1`.`Lat`,
                         `T1`.`Lon`,
                         `T1`.`Magnitude`
                  FROM disasters_organizations_services T1
                  LEFT OUTER JOIN organizations T2
                  ON T1.organization_ID = T2.ID
                  LEFT OUTER JOIN services T3
                  ON T1.service_ID = T3.ID
                  WHERE (`T1`.`disaster_id` = %r)""", disaster_id)

spreadsheet = csvwriter(sys.stdout)
spreadsheet.writerow('org_name org_id service_name service_id lat lon mag'.split())
for row in cursor.fetchall():
    spreadsheet.writerow(row)
