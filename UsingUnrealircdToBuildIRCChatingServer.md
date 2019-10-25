#### Using Unrealircd to build a local IRC chating server

##### What's the IRC?
The IRC all name is `Internet Relay Chat`, a internet chat protocol created by a finn named Jarkko Oikarinen, [see more](https://wiki.mozilla.org/IRC).

Oh, my pc operation is deepin-15.11.

##### Building a IRC server by unrealircd.
* Downloading and Unpacking
    * `wget  https://www.unrealircd.org/downloads/unrealircd-4.2.4.1.tar.gz`
    * `tar -zxf unrealircd-4.2.4.1.tar.gz`
* Setting and Installing
    * about setting, you should excute `./Config`, according to the notice, you may follow it;
    * Then `sudo make && sudo make install`;
    * this will install at dir `~/unrealircd`, cd there, and `chown` all.
    * exp. `chown unrealircd:unrealircd ./ -R`.
* Starting
    * Not easy to start, there are some arguments to define yourself;
    * Then you can use `./unrealircd start`.
##### End
After above all, you can open your `Pidgin` to enter the server and chat, if there not only you.