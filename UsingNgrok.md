#### Using ngrok on ubuntu 18.04

*Sometimes, my friends need help, and I would to write some programs, but I don't have a server. So this tool can help me much.*

If you don't have account, please register by yourself. I have registered before. After login, you can create your free channel. according to guidance, you can complete it. I have no time to say more about this, because it's to easy, ngrok has its document.

Now, after downloading [starter](http://hls.ctopus.com/sunny/linux_amd64.zip?v=2), and unzipping it, you can use it in terminal, liking `./sunny clientid yourChannelClientId`. It seems ok, but I think it's a trouble, so edit a sh file to start it, but no operation to change clientId.
```bash
#!/bin/bash
/home/${USER}/bin/sunny clientid yourClientId
```

You can click [here](https://www.ngrok.cc) to learn more about ngrok.