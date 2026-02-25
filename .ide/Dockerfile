FROM alpine:3.22

LABEL maintainer="Tongle Xu <xutongle@msn.com>" version="1.0" license="MIT"

# 更新系统
RUN set -ex \
    && sed -i 's/dl-cdn.alpinelinux.org/mirrors.ustc.edu.cn/g' /etc/apk/repositories \
    && apk update \
    && apk add --no-cache openssh_server curl

# 安装 code-server 和 PHP 开发扩展
RUN curl -fsSL https://code-server.dev/install.sh | sh \
    && code-server --install-extension bmewburn.vscode-intelephense-client \
    && code-server --install-extension xdebug.php-debug \
    && code-server --install-extension formulahendry.code-runner \
    && code-server --install-extension ms-vscode.vscode-typescript-next \
    && code-server --install-extension esbenp.prettier-vscode \
    && code-server --install-extension tencent-cloud.coding-copilot \
    && code-server --install-extension zobo.php-intellisense

# 复制 vscode 自定义到容器中
COPY .ide/settings.json /root/.vscode-server/data/Machine/settings.json
COPY .ide/settings.json /root/.local/share/code-server/Machine/settings.json

# 指定字符集支持命令行输入中文
ENV LANG C.UTF-8
ENV LANGUAGE C.UTF-8
