# dc-aichat 1.0.0

**写在最前：**

ChatGPT的横空出世真的改变了世界，用过的人都知道ChatGPT完全可以作为生产力工具应用在很多领域。可以说ChatGPT是最近几年又一个的巨大风口，目前大量投资机构和政府部门都在鼓励和支持相关行业的发展。近几年，国内大模型雨后春笋版蓬勃发展，出现了很多优秀的大模型。这个源码Demo就是整合了国内比较流行的几个大模型。

目前本源码支持模型如下：ChatGPT、智谱AI、讯飞星火、书生浦语大模型、Kimi.ai（Moonshot AI）、豆包AI，等等。想接入更多的模型，可以自己修改代码接入。

请点下右上角的小星星，方便您随时找到本项目。

**首次使用配置：**

1、编辑stream.php文件，从第19行开始，修改为自己的API接口，一般修改API密钥即可，请求URL是相同的。（可以到对应的大模型官网申请API和密钥）
2、编辑index.php文件，从第72行开始，修改前端的可选模型列表，注意value值要跟stream.php中自己设置的值一致。
3、编辑setsession.php文件，第11行，修改默认模型编码。这样用户打开网页就默认使用这个模型。

修改完了上传到网站服务器即可使用，可以运行在根目录也可以二级目录。

**本项目完全开源，是PHP版调用大模型的API接口进行问答的Demo，有以下特性和功能：**

1. 对PHP版本无要求，不需要数据库。核心代码只有几个文件，没用任何框架，修改调试很方便。
2. 采用stream流模式通信，一边生成一边输出，响应速度全网最快。
3. 支持ChatGPT、智谱AI、讯飞星火、书生浦语大模型、Kimi.ai（Moonshot AI）、豆包AI等各种模型（想接入更多的模型，可以自己修改代码接入）。
4. 支持Markdown格式文本显示，如表格、代码块。对代码进行了着色，提供了代码复制按钮，支持公式显示。
5. 支持多行输入，文本框高度自动调节，手机和PC端显示都已做适配。
6. 支持一些预设话术，支持上下文连续对话，AI回答途中可以随时打断。
7. 支持错误处理，接口返回错误时可以看到具体原因。
8. 支持禁止外部URL调用本站接口。

**本项目定位是个人或朋友之间分享使用，轻量设计，不计划引入数据库等复杂功能。有需要的用户可以自行拿去修改。对于项目UI或其他功能有改进想法的朋友欢迎提交PR，或者在Issues或Discussions进行讨论。**

------
# 演示网站：https://5300.cn/chat/

演示站现在可以免费使用智谱AI、讯飞星火、书生浦语大模型、Kimi.ai（Moonshot AI）、豆包AI等对话了。全网最易部署，响应速度最快的AIGC环境。PHP版调用各种模型接口进行问答和对话，采用Stream流模式通信，一边生成一边输出。前端采用EventSource，支持Markdown格式解析，支持公式显示，代码有着色处理。页面UI简洁，支持上下文连续会话。源码只有几个文件，没用任何框架，支持所有PHP版本，全部开源，极易二开，一切全免费。

<img src="https://github.com/dengcao/dc-aichat/blob/main/demo/main.png?raw=true" width="70%" alt="main.png">

<img src="https://github.com/dengcao/dc-aichat/blob/main/demo/demo1.png?raw=true" width="70%" alt="demo1.png">

<img src="https://github.com/dengcao/dc-aichat/blob/main/demo/demo2.png?raw=true" width="70%" alt="demo2.png">

<img src="https://github.com/dengcao/dc-aichat/blob/main/demo/demo3.png?raw=true" width="70%" alt="demo3.png">

<img src="https://github.com/dengcao/dc-aichat/blob/main/demo/demo4.png?raw=true" width="70%" alt="demo4.png">


# 更新说明

**版本1.0.0，主要更新内容：**

1、新增：智谱AI、讯飞星火、书生浦语大模型、Kimi.ai（Moonshot AI）、豆包AI等模型。

2、前端可以自由选择模型。

3、增加了防止外网盗用接口的功能。

# 特别鸣谢

dc-aichat使用了以下开源代码：

dirk1983/chatgpt、layer、jquery等。

特别致谢！

# 赞助支持：

支持本程序，请到Gitee和GitHub给我们点Star！

Gitee：https://gitee.com/dengzhenhua/dc-aichat

GitHub：https://github.com/dengcao/dc-aichat

# 关于

开发：[邓草博客 blog.5300.cn](http://blog.5300.cn)

赞助：[品络互联 www.pinluo.com](http://www.pinluo.com)  &ensp;  [AI工具箱 5300.cn](http://5300.cn)  &ensp;  [汉语言文学网 hyywx.com](http://hyywx.com)  &ensp;  [雄马 xiongma.cn](http://xiongma.cn) &ensp;  [优惠券 tm.gs](http://tm.gs)


------
**本项目常见问题：**

1. 在国内环境使用提示OpenAI连接超时

是的，OpenAI官方不支持中国（含港澳台地区）IP访问接口。解决方案：使用境外服务器部署本项目，如美国、韩国、日本等，比如腾讯云日本就可以。

2. 大模型的API接口去哪里申请？

百度搜索一下对应的模型名称，比如：智谱AI。找到官网后，注册账号，按提示申请API即可。

目前，国内有很多接口是免费的，比如：智谱AI（GLM-4-Flash）、

3. 关于Stream流模式的原理，为什么你部署的不像我的那么快

本项目前端使用的是Javascript的EventSource方式与后端进行通信，可以实现数据的流模式即时传输，而OpenAI接口也是支持数据实时生成实时传输的，因此才能实现问答的秒回。EventSource模式的缺点是不支持POST方式传递数据，GET方式对数据长度有限制，cookie也有限制，所以选择了分两步请求后端，采用SESSION传递数据。至于为什么你用我的代码部署的网站速度比较慢，主要原因除了服务器的问题，可能还有PHP环境的问题。PHP如果想实现流式输出需要关闭输出缓存，可能需要修改apache或nginx及php.ini的配置，具体修改方式可以自行搜索。

4. 如果想实现像Demo站一样的功能，怎么修改代码？

参考前面的：首次使用配置说明。

5. 目前国内AI大模型可以做些什么？

目前国内大都为认知智能模型，可以帮助您完成以下任务（以下为AI回答内容）：
语言理解：我可以准确理解您提出的各种问题或指令，并做出相应的回应。
问答服务：我可以回答各种问题，包括常识性问题、学术性问题、技术性问题等等。
提供建议：如果您需要一些建议或者意见，我可以为您提供参考和建议。
翻译服务：我可以帮您翻译多种语言之间的文本内容，包括中文、英文、法文、德文、日文等等。
写作辅助：如果您需要写论文、报告或者其他类型的文档，我可以为您提供写作方面的帮助和指导。
娱乐休闲：如果您感到无聊或者需要一些娱乐休闲，我可以与您聊天、玩游戏、听音乐等等。
情感交流：我还能在一定程度上模拟人类的情感反应，与您进行更自然的对话互动。
知识查询：如果您需要查找特定的资料或数据，我可以迅速为您提供相关信息。

------
