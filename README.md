# vk-publisher
Publish comments to vk publics


1) Create standalone application: 
https://vk.com/apps?act=manage
2) Get application id and secure key, 
then go to settings.php and change it.
3) Open index.php
Click "Получить код";
You will redirect to VK page, and there
will be address "https://oauth.vk.com/blank.html#code=....."
copy this code, and enter it, where's ACCESS TOKEN constant.
After this, reload the page, it works!

You can add more than one group, if you just seperate them by
space. You can use id or group name. Like these: "futurelife 12345454".
Be careful, you can't use full address like: "public21345454", "club123432".
You should copy the part where's id "21345454" or "123432".
