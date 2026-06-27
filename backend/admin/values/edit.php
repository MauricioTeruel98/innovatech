<?php
require_once dirname(__DIR__) . '/includes/auth_guard.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__) . '/includes/crud.php';
crud_edit(getDB(), require __DIR__ . '/_resource.php');
