FROM ubuntu:24.04

LABEL maintainer="Tongle Xu"

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN echo "Acquire::http::Pipeline-Depth 0;" > /etc/apt/apt.conf.d/99custom && \
    echo "Acquire::http::No-Cache true;" >> /etc/apt/apt.conf.d/99custom && \
    echo "Acquire::BrokenProxy    true;" >> /etc/apt/apt.conf.d/99custom

RUN sed -i 's@//.*archive.ubuntu.com@//mirrors.cloud.tencent.com@g' /etc/apt/sources.list.d/ubuntu.sources \
    && sed -i 's@//security.ubuntu.com@//mirrors.ustc.edu.cn@g' /etc/apt/sources.list.d/ubuntu.sources \
#    && sed -i 's/http:/https:/g' /etc/apt/sources.list.d/ubuntu.sources \
    && apt-get update && apt-get upgrade -y \
    && mkdir -p /etc/apt/keyrings \
    && apt-get install -y gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python3 dnsutils librsvg2-bin  \
    && curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0xb8dc7e53946656efbce4c1dd71daeaab4ad4cab6' | gpg --dearmor | tee /etc/apt/keyrings/ppa_ondrej_php.gpg > /dev/null \
    && echo "deb [signed-by=/etc/apt/keyrings/ppa_ondrej_php.gpg] https://launchpad.proxy.ustclug.org/ondrej/php/ubuntu noble main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get install -y php8.4-cli php8.4-dev \
       php8.4-pgsql php8.4-sqlite3 php8.4-gd php8.4-imagick \
       php8.4-curl php8.4-mongodb \
       php8.4-imap php8.4-mysql php8.4-mbstring \
       php8.4-xml php8.4-zip php8.4-bcmath php8.4-soap \
       php8.4-intl php8.4-readline \
       php8.4-ldap \
       php8.4-msgpack php8.4-igbinary php8.4-redis php8.4-swoole \
       php8.4-memcached \
    && apt-get update \
    && apt-get install -y mysql-client \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && setcap "cap_net_bind_service=+ep" /usr/bin/php8.4 \
    && echo "[PHP]
post_max_size = 100M
upload_max_filesize = 100M
variables_order = EGPCS

date.timezone = Asia/Shanghai
opcache.enable_cli = 'On'
swoole.use_shortname='Off'" >> /etc/php/8.4/cli/conf.d/99-php.ini

# 安装 Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 安装 code-server 和 PHP 开发扩展
RUN curl -fsSL https://code-server.dev/install.sh | sh \
    && code-server --install-extension bmewburn.vscode-intelephense-client \
    && code-server --install-extension xdebug.php-debug \
    && code-server --install-extension formulahendry.code-runner \
    && code-server --install-extension ms-vscode.vscode-typescript-next \
    && code-server --install-extension esbenp.prettier-vscode \
    && code-server --install-extension tencent-cloud.coding-copilot \
    && code-server --install-extension zobo.php-intellisense

# 指定字符集支持命令行输入中文
ENV LANG C.UTF-8
ENV LANGUAGE C.UTF-8
