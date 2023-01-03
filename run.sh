#!/usr/bin/env bash

tmux \
    new-session  'npm run dev' \; \
    split-window 'php artisan serve'