set nu
set nowrap
set background=dark
set encoding=utf-8
set fileencoding=utf-8

noremap <F3> <Esc>:TlistToggle <CR>
noremap <F8> <Esc>:! $DEV_HOME/yueyue/rigger.sh cmd=conf sys=all env=dev <CR> <Esc>:! $DEV_HOME/yueyue/rigger.sh cmd=restart <CR>
noremap <F9> <Esc>:! $DEV_HOME/yueyue/project/srcindex_cscope.sh <CR> <Esc>: execute "cs add ".$DEV_HOME/yueyue."/tmp/cscope.out" <CR>
"noremap <F9> <Esc>:! $DEV_HOME/yueyue/project/srcindex_ctags.sh <CR>
