# webgptproxy


1，先配置好web服务：apache or nginx
    
    php需要打开curl扩展
    
    将代码放到配置的web路径的目录
    git clone https://github.com/christieheli/webgptproxy.git

2，修改openai.php文件的APPKEY值

3，代理接口：
  
  openai chat completion接口
  
  请求代理接口，post的数据，就是原接口提示语prompt格式的json串
  
  http://xxx/chat.php?action=conversation
  
  openai embeddings接口
  
  请求代理接口， post的数据格式为：{"content":"文本内容"}
  
  http://xxx/chat.php?action=embeddings
