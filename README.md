streamtoolbox-examples
=====================

Examples for the plugins on [Streamtoolbox.com](https://streamtoolbox.com) that help seamless integration between Wowza Streaming Engine&reg; and your own video streaming system.

- [Wrench](https://streamtoolbox.com/wrench): provides flexible authentication, authorization mechanisms for both your stream consumers and producers. Provides pay-per-minute and pay-per-view solutions and much more.
- [Scissor](https://streamtoolbox.com/scissor): API call driven playlist compilation, change between live streams and VOD content
- [Measure](https://streamtoolbox.com/measure): log player counts per stream, per streaming technology and per Wowza application using your own predefined SQL queries into your database

## Examples for Wrench


1. ~~Simple authentication with PHP frontend and MySQL database (`01-simple-authentication`)~~

Shows how we did things a decade ago, kept here for reference only. Functionally equivalent
to `02-auth-with-php-mysql`

2. [Authentication with PHP webapp and MySQL database (`02-auth-with-php-mysql`)](./wrench/02-auth-with-php-mysql/)

Minimal video site (PHP backend, HTML+JS frontend) that uses a MySQL database for storing users. Once the user logs in, a token is dynamically generated and stored in the database. This token is then put into video links so that Wrench can authenticate the user. All connections without a valid token are refused, a predefined
token is required for publishing a demo stream.

![PHP Login Screen](./wrench/02-auth-with-php-mysql/screenshot-1.png) 
![Protected Video Site](/wrench/02-auth-with-php-mysql/screenshot-2.png)

3. [JWT Authentication with PHP webapp and MySQL database (`03-jwt-authentication`)](./wrench/03-jwt-authentication/)

Similar to the previous example but uses JWT (JSON Web Tokens) for authentication instead of storing tokens in the database. When a user logs in, a JWT token is generated containing the username. This token is then used in video links for authentication. The JWT approach eliminates the need to store and manage tokens in the database while providing secure, stateless authentication.

![JWT Authentication Example](./wrench/03-jwt-authentication/screenshot-2.png)

4. [Pay-per-minute publisher tracking (`04-pay-per-minute-publisher`)](./wrench/04-pay-per-minute-publisher/)

Uses Docker Compose to start a MySQL database and configures Wrench's PPM SQL hooks so an authenticated RTMP publisher's connected seconds are captured in the database.
