ブラウザでPHPためせる君（仮称）開発中です（WIP)
=========================================

ウェブブラウザでPHPのコードを試せます。
サンドボックスを使っているので、危ないコードは動かない（筈）。


# REQUIRE

- PHP>=5.4
- (composer)
- bower(node.js)

bowerのためだけにnode.jsが必要なのは不便なので（特にWindowsの人には…）、将来的には、ビルド版を作ろうとおもいます。
（bowerphpというものがありますが、ace-buildsがDLできない…）


# SETUP

```
$ composer install
$ pake html_setup
$ php -S 127.0.0.1:8080 # or upload
```
