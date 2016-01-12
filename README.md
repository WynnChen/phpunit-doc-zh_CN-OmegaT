# OmegaT 项目文件：phpunit 文档简体中文翻译

本项目是 OmegaT 所使用的翻译项目文件。
翻译内容为 phpunit 文档。
源语言为 English，目标语言为简体中文。

自 phpunit 3.7 开始有中文文档翻译。

## 相关需求与下载

- OmegaT：http://www.omegat.org/
- PHP： http://php.net/
- phpunit 文档项目： https://github.com/sebastianbergmann/phpunit-documentation

可选：
- 编译 phpunit 文档相关工具： 参见 phpunit 文档项目说明。

## 工作流程

1. 清理：将 phpunit-doc-zh_CN-OmegaT 目录下 source 与 target 两个子目录清空，删除其下的所有内容
1. 从 phpunit 文档项目处取得待译 phpunit 文档
2. phpunit-documentation/src 目录下所有要翻译为中文的文档版本子目录复制至 phpunit-doc-zh_CN-OmegaT/source 目录下
3. 运行 phpunit-doc-zh_CN-OmegaT 目录下的 pre.php，进行必要的预处理：
    cd phpunit-doc-zh_CN-OmegaT
    php pre.php
4. 预处理完成后，启动 OmegaT，打开本翻译项目，进行翻译工作。
5. 全部翻译完成后，生成已译文件。
6. 运行 phpunit-doc-zh_CN-OmegaT 目录下的 post.php，进行必要的后处理：
    cd phpunit-doc-zh_CN-OmegaT
    php post.php
7. 后处理完成后，将 phpunit-doc-zh_CN-OmegaT/target 下的内容复制回 phpunit-documentation/src，覆盖原有文件

## 注意事项

- 预处理与后处理需要正确进行。
- 合并回 phpunit-documentation 之后最好编译一下 phpunit 文档检查是否有问题。
- 如果 phpunit-documentation 源文件中的 copyright.xml 有所更新，需要人工进行翻译更新，并用新版本替换 phpunit-doc-zh_CN-OmegaT/copyright.xml

## 预处理与后处理

这里描述的是一些具体的实现细节，与翻译本身没有大关联，只想进行翻译的话可以不再往下看。

### 问题

- phpunit 文档的源文件并不是完全标准的 DocBook XML 文件，无法直接导入 OmegaT。
- 我只关心从 English 到简体中文的翻译工作，其他语言与我的工作无关。
- copyright.xml 文件的内容严重干扰了 OmegaT 的自动匹配等机制。
- 要正确处理语言相应目录名的问题，很麻烦。

### 应对

引入预处理与后处理脚本，在翻译前后进行这些附加工作。

pre.php 对未译源文件进行如下操作：

- 去除所有非 English 版本，只保留 en 子目录
- 用预制的中文版本 copyright.xml 替换现有的 copyright.xml 文件
- 处理所有其他的 .xml 文件，使其符合标准 DocBook 格式

post.php 对已译目标文件进行如下操作：

- 将 en 目录名改为 zh_CN
- 将 .xml 文件转回 phpunit 文档项目所用的格式

由于预处理中未对 copryright.xml 进行格式处理，OmegaT 不会将其识别为可翻译文件，原样输出至已译文件，不需要在后处理中另行处理。

### 限制

- 目前两个脚本依赖于 Windows 系统，因为调用了 cmd 命令
- copyright.xml 需要自行人工判定是否有更新，如果有更新需手工处理
