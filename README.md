# pay
个人网站即时到账收款解决方案  
Personal website instant payment solution   
 
## Links
- [Tutorial](https://blog.xu42.cn/2017/11/26/person-website-instant-payment-solution/)
- [Demo](https://pay.xu42.cn)

## SDK
- [youzan-sdk-go](https://github.com/xu42/youzan-sdk-go)
- [youzan-sdk-php](https://github.com/xu42/youzan-sdk-php)

## Deploy
### 只提供一个思路, 不推荐部署在生产环境

1. 按照博客文章里的提示, 打开[控制台](https://console.youzanyun.com/application/setting), 记下client_id/client_secret/授权店铺id, 补充到[YouzanYunService](src/Service/YouzanYunService.php)文件里
2. 如果没有域名证书或不打算使用, 需要修改[index.php](public/index.html)中的`wss` 为 `ws`, 并删除[start.php](src/start.php)中的`ssl`相关的代码
3. 全局搜索替换`pay.xu42.cn`为你的域名
4. 涉及到的几个端口号可以自行修改(为什么是这几个端口号? 哈哈 好问题 `119`是我女朋友生日~)
5. 飞起来 `php /path/src/start.php`
 
## Contact
 - [微信公众号留言入群](https://open.weixin.qq.com/qr/code?username=gh_4a7a236c1af2)
 
