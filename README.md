![Logo](https://github.com/rapiddev/Forward/blob/master/media/img/forward-logo-bk.png?raw=true)
# Forward
[Created with ![heart](http://i.imgur.com/oXJmdtz.gif) in Poland by RapidDev](https://rdev.cc/)<br />
Now you can have your own Bit.ly or Google URL shortener equivalent.
Forward is a simple PHP-based tool with which you can shorten links and collect statistics about activity.

## What data can I collect?
With the help of Forward you can collect information about:
- The number of clicks on the link
- The language of the browser the user has
- Where the click comes from (e.g., Facebook / YouTube)

## Dashboard
Simple intuitive interface modeled on Adobe and Bit.ly websites.
<br/><br/>
![Login form](https://github.com/rapiddev/Forward/blob/master/media/img/forward-screen-1.png?raw=true)
<br/><br/>
![Dashboard](https://github.com/rapiddev/Forward/blob/master/media/img/forward-screen-2.png?raw=true)
<br/><br/>
![Options](https://github.com/rapiddev/Forward/blob/master/media/img/forward-screen-3.png?raw=true)

## Security
Forward uses a number of security features. User passwords are encrypted via SHA256 and Argon 2.
The session has a generated token, saved in the database, which is verified each time.
Each Ajax query is verified by the SHA1 encrypted Nonce.

## Roles
- Administrator<br/>Has full permissions to do everything.
- Manager<br/>Can add and delete records. Cannot change settings or add users.
- Analyst<br/>Can only view data.

## What do we get?
- [x] Fast link management system
- [x] Automatic installation
- [x] Animated charts
- [x] Administration panel
- [x] User roles
- [x] Global statistics
- [x] Multilingual dashboard
- [x] The ability to create multiple users

## How to install it?
Simply upload files to your hosting using FTP or on your test environment. Installation will start from the root directory.
Just press "Install". It's easy: D

### Available full language versions
- [x] English
- [x] Polish

### Third party solutions
- Chartist.js by the Gion Kunz<br/>[https://github.com/gionkunz/chartist-js](https://github.com/gionkunz/chartist-js)
- Bootstrap by the Bootstrap team<br/>[https://getbootstrap.com/](https://getbootstrap.com/)
- jQuery by the jQuery Foundation<br/>[https://jquery.org/](https://jquery.org/)
- Clipboard.js by the Zeno Rocha<br/>[https://github.com/zenorocha/clipboard.js/](https://github.com/zenorocha/clipboard.js/)
- Material Design Icons by the Google and other creators | Maintained by Austin Andrews<br/>[https://materialdesignicons.com/](https://materialdesignicons.com/)
- Picture of mountains by the Joyston Judah<br/>[https://www.pexels.com/@joyston-judah-331625](https://www.pexels.com/@joyston-judah-331625)
- Questrial font by the Joe Prince<br/>[https://fonts.google.com/specimen/Questrial](https://fonts.google.com/specimen/Questrial)
- Design inspired by the Bit.Ly<br/>[https://bitly.com/](https://bitly.com/)
