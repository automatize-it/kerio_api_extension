# kerio_api_extension
My extension of Kerio API, currently allows to add IP addresses to lists in Kerio Control

This is extension of beta API for old Kerio products (Control, Connect), currently provides function of modifying IP-list in Kerio Control,
for example Fail2Ban and other autoban software may need it.

This function was not in beta API that I found and wasn't started to be implemented due to json encoding difficulties (my best guess)

No warranties whatsoever, use as is at your own risk.

You will need:
- api itself (http://www.kerio.ru/learn-community/developer-zone/details)
- web-server (blame Kerio)
- files from repo

Install:
- put api in www folder on you web-server
- replace KerioApi.php by modified from this repo
- enter your Kerio Control creds on main api page
- place setBlcklstdIp.php in kerio api "examples" dir

Usage:
https://your.server/kerio/examples/control/setBlcklstdIp.php?blstdip=ip&group=groupCode

Group code can be obtained in Control cfg files or via browser debugger.
