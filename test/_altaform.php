<?php

if (!$af->debug()) \af\error(404);
if (!\af\cli()) $user->requireAdmin();

