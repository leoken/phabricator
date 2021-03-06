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

abstract class DifferentialRevisionDetailRenderer {

  /**
   * This function must return an array of action links that will be
   * added to the end of action links on the differential revision
   * page. Each element in the array must be an array which must
   * contain 'name' and 'href' fields. 'name' will be the name of the
   * link and 'href' will be the address where the link points
   * to. 'class' is optional and can be used for specifying a CSS
   * class.
   */
  abstract public function generateActionLinks(DifferentialRevision $revision,
                                               DifferentialDiff $diff);

  /**
   * This function must return an array of properties. These
   * properties will be shown below other properties on differential
   * revision page. Array keys are used for property names and array
   * values are used for the actual property values. These property
   * values will be displayed on the page as they are given, so they
   * should be properly escaped.
   */
  abstract public function generateProperties(DifferentialRevision $revision,
                                              DifferentialDiff $diff);
}
