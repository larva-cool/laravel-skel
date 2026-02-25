FROM ubuntu:24.04

LABEL maintainer="Tongle Xu"

ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN echo "Acquire::http::Pipeline-Depth 0;" > /etc/apt/apt.conf.d/99custom && \
    echo "Acquire::http::No-Cache true;" >> /etc/apt/apt.conf.d/99custom && \
    echo "Acquire::BrokenProxy    true;" >> /etc/apt/apt.conf.d/99custom

RUN sed -i 's@//.*archive.ubuntu.com@//mirrors.aliyun.com@g' /etc/apt/sources.list.d/ubuntu.sources \
    && sed -i 's@//security.ubuntu.com@//mirrors.ustc.edu.cn@g' /etc/apt/sources.list.d/ubuntu.sources

# 安装开发工具和依赖
RUN apt-get update && \
    apt-get install -y \
            build-essential \
            cmake clang llvm-dev libclang-dev \
            git curl \
            wget zip unzip lsof nload htop net-tools dnsutils openssh-server vim \
            # PHP 相关依赖
            libzip-dev \
            libpng-dev \
            libjpeg-dev \
            libfreetype6-dev \
            libonig-dev \
            libxml2-dev \
            libcurl4-openssl-dev \
            libssl-dev \
            libsqlite3-dev \
            libpq-dev \
            libmemcached-dev \
            librdkafka-dev \
            zlib1g-dev \
            libicu-dev \
            g++ && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# 安装 PHP 和扩展


# 安装 Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

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
