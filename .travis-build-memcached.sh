#!/bin/sh

apt-get remove php5-memcached
apt-get install libjson-c2 php5-json

mkdir -p build/pecl/ && cd build/pecl/
wget http://pecl.php.net/get/memcached-2.2.0.tgz
tar xzf memcached-2.2.0.tgz
cd memcached-2.2.0/

phpize
./configure --enable-memcached-igbinary --enable-memcached-json

make
echo "n" | make test
if [ $? -ne 0 ]; then exit -1; fi
make install
cd ../../../
