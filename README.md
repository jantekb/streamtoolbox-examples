streamtoolbox-examples
=====================

Examples for the various tools on Streamtoolbox.com that help seamless integration between Wowza Streaming Engine&reg; and your own video streaming system.

- [Wrench](https://streamtoolbox.com/wrench): this tools provides flexible authentication, authorization mechanisms for both your stream consumers and producers. Also provides pay-per-minute and pay-per-view solutions and much more.
- [Measure](https://streamtoolbox.com/measure): log player counts per stream, per streaming technology and per Wowza application using your own predefined SQL queries into your database
- [Clamp](https://streamtoolbox.com/clamp): add captions to your live streams on-the-fly from a text file. This can be used for service information, advertisements, etc.

## Examples for Wrench

1. Simple authentication with PHP frontend and MySQL database (`01-simple-authentication`)

This example shows how to create a minimal video site which uses a MySQL database for storing users. Once the user gets in, a token is dynamically generated for him and stored in the database. This token is then put into video links so that Wrench can authenticate the user. All connections without a valid token are refused.

### Setup instructions

Easiest if you [watch this YouTube video](https://www.youtube.com/watch?v=vDln3bqVmIk) and follow the instruction.

[![Video Cover image](/wrench/01-simple-authentication/video-cover.png)](https://www.youtube.com/watch?v=vDln3bqVmIk)

1. Download the full example package from GitHub
1. Install an Apache/MySQL stack, like XAMPP
1. Copy the contents of `www` into your webserver's `htdocs` folder
1. Log into the MySQL database and run `sql/setup.sql` script to create the database, user, tables and minimal data
1. Copy the contents of the `wowza` directory into your own Wowza Streaming Engine installation to define the streaming application
1. Download the [latest version of Wrench](https://streamtoolbox.com/download#wrench) and put the jar file under your Wowza's `lib` directory
1. Download the [latest MySql JDBC connector](http://dev.mysql.com/downloads/connector/j/5.0.html) and put the jar file under your Wowza's `lib` directory
1. Start your Wowza Streaming Engine
1. Publish your live stream, e.g webcam from [Flash Media Live Encoder]() into your Wowza server. Details on this can be found [in this article](https://streamtoolbox.com/user-authentication).
The FMS url you need to use is `rtmp://localhost:1935/wrenchexample1?t=encodersecret` (this is given as encoder token in the provided `Application.xml`) and stream name should be `mystream`.

![PHP Login Screen](/wrench/01-simple-authentication/screenshot-0.png)
![Protected Video Site](/wrench/01-simple-authentication/screenshot-1.png)

## Examples for Clamp

1. Dynamic text caption on a live stream from text file

This example demonstrates how to put arbitrary text messages on your live video stream from a text file. Just [follow this YouTube video](https://www.youtube.com/watch?v=quTyvWa6kD0):

[![Video Cover image](/clamp/01-file-caption-source/video-cover.png)](https://www.youtube.com/watch?v=quTyvWa6kD0)

  