# webgptproxy


1，先配置好web服务：apache or nginx
    
    php需要打开curl扩展
    
    将代码放到配置的web路径的目录
    git clone https://github.com/christieheli/webgptproxy.git

2，修改openai.php文件的key值

3，代理接口：
  
  openai chat completion接口
  
  http://xxx/chat.php?action=conversation
  
  openai embeddings接口
  
  http://xxx/chat.php?action=embeddings
