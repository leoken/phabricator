<?php

/*
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Default storage engine selector. See
 * @{class:PhabricatorFileStorageEngineSelector} and @{article:File Storage
 * Technical Documentation} for more information.
 *
 * @group filestorage
 */
final class PhabricatorDefaultFileStorageEngineSelector
  extends PhabricatorFileStorageEngineSelector {

  /**
   * Select viable default storage engines according to configuration. We'll
   * select the MySQL and Local Disk storage engines if they are configured
   * to allow a given file.
   */
  public function selectStorageEngines($data, array $params) {
    $length = strlen($data);

    $mysql_key = 'storage.mysql-engine.max-size';
    $mysql_limit = PhabricatorEnv::getEnvConfig($mysql_key);

    $engines = array();
    if ($mysql_limit && $length <= $mysql_limit) {
      $engines[] = new PhabricatorMySQLFileStorageEngine();
    }

    $local_key = 'storage.local-disk.path';
    $local_path = PhabricatorEnv::getEnvConfig($local_key);
    if ($local_path) {
      $engines[] = new PhabricatorLocalDiskFileStorageEngine();
    }

    if ($mysql_limit && empty($engines)) {
      // If we return no engines, an exception will be thrown but it will be
      // a little vague ("No valid storage engines"). Since this is a default
      // case, throw a more specific exception.
      throw new Exception(
        "This file exceeds the configured MySQL storage engine filesize ".
        "limit, but no other storage engines are configured. Increase the ".
        "MySQL storage engine limit or configure a storage engine suitable ".
        "for larger files.");
    }

    return $engines;
  }

}
