<?php
/**
 * Minimum framework for Kiara
 *
 * Copyright (c) Thibault Forax
 *
 * Licensed under MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 */
namespace Framework;

class Form
{
    private $validRuleList;
    private $data;

    public function __construct($validRuleList, $data, $prepareAllField = true)
    {
        $this->validRuleList = $validRuleList;
        $this->data = $data;
        if ($prepareAllField === true) {
            foreach ($this->data as $key => $value) {
                if (!isset($this->validRuleList[$key])) {
                    $this->validRuleList[$key]['prepare'] = array(
                        'trim' => true,
                        'htmlspecialchars' => true,
                        'addslashes' => true
                    );
                }
            }
        }
    }

    public function isIdentical($value, $field)
    {
        if ($value != $this->data[$field]) {
            return false;
        }
        return true;
    }

    public function isIp($value, $type = false)
    {
        $filterFlag = null;
        if ($type !== false) {
            if ($type == 'ipv4') {
                $filterFlag = FILTER_FLAG_IPV4;
            } else if ($type == 'ipv6') {
                $filterFlag = FILTER_FLAG_IPV6;
            }
        }
        if (filter_var($value, FILTER_VALIDATE_IP, $filterFlag)) {
            return true;
        }
        return false;
    }

    public function isNotEmpty($value)
    {
        if ($value == '') {
            return false;
        }
        return true;
    }

    public function isPasswordStrength($value, $digit = false, $lower = false, $upper = false, $symbol = false)
    {
        if ($digit !== false) {
            if (!preg_match("#[0-9]+#", $value)) {
                return false;
            }
        }
        if ($lower !== false) {
            if (!preg_match("#[a-z]+#", $value)) {
                return false;
            }
        }
        if ($upper !== false) {
            if (!preg_match("#[A-Z]+#", $value)) {
                return false;
            }
        }
        if ($symbol !== false) {
            if (!preg_match("#\W+#", $value)) {
                return false;
            }
        }
        return true;
    }

    public function isStringLength($value, $min = false, $max = false)
    {
        $value = stripslashes($value);
        if ($min !== false) {
            if (strlen($value) < $min) {
                return false;
            }
        }
        if ($max !== false) {
            if (strlen($value) > $max) {
                return false;
            }
        }
        return true;
    }

    public function prepare()
    {
        // Parcours les champs a preparer
        foreach ($this->validRuleList as $field => $fieldRuleList) {
            $trim = true;
            $htmlSpecialchars = true;
            $addslashes = true;
            $stripTags = false;
            if (isset($fieldRuleList['prepare'])) {
                if (isset($fieldRuleList['prepare']['trim'])) {
                    $trim = $fieldRuleList['prepare']['trim'];
                }
                if (isset($fieldRuleList['prepare']['htmlspecialchars'])) {
                    $htmlSpecialchars = $fieldRuleList['prepare']['htmlspecialchars'];
                }
                if (isset($fieldRuleList['prepare']['addslashes'])) {
                    $addslashes = $fieldRuleList['prepare']['addslashes'];
                }
                if (isset($fieldRuleList['prepare']['stripTags'])) {
                    $stripTags = $fieldRuleList['prepare']['stripTags'];
                }
            }
            if (isset($this->data[$field])) {
                $fieldContent = $this->data[$field];
                if ($trim) {
                    if (is_array($fieldContent)) {
                        $fieldContent = $this->recursivePrepare('trim', $fieldContent);
                    } else {
                        $fieldContent = trim($fieldContent);
                    }
                }
                if ($stripTags) {
                    if (is_array($fieldContent)) {
                        $fieldContent = $this->recursivePrepare('strip_tags', $fieldContent);
                    } else {
                        $fieldContent = strip_tags($fieldContent);
                    }
                }
                if ($htmlSpecialchars) {
                    if (is_array($fieldContent)) {
                        $fieldContent = $this->recursivePrepare('htmlspecialchars', $fieldContent);
                    } else {
                        $fieldContent = htmlspecialchars($fieldContent);
                    }
                }
                if ($addslashes) {
                    if (is_array($fieldContent)) {
                        $fieldContent = $this->recursivePrepare('addslashes', $fieldContent);
                    } else {
                        $fieldContent = addslashes($fieldContent);
                    }
                }
                $this->data[$field] = $fieldContent;
            } else {
                $this->data[$field] = '';
            }
        }
        return $this->data;
    }

    public function recursivePrepare($callback, $list)
    {
        $returnList = array();
        foreach ($list as $key => $value) {
            if (is_array($value)) {
                $returnValue = $this->recursivePrepare($callback, $value);
            } else {
                if ($callback == 'trim') {
                    $returnValue = trim($value);
                } else if ($callback == 'strip_tags') {
                    $returnValue = strip_tags($value);
                } else if ($callback == 'htmlspecialchars') {
                    $returnValue = htmlspecialchars($value);
                } else if ($callback == 'addslashes') {
                    $returnValue = addslashes($value);
                }
            }
            $returnList[$key] = $returnValue;
        }
        return $returnList;
    }

    public function validate()
    {
        foreach ($this->validRuleList as $field => $fieldRuleList) {
            $optionnal = false;
            if (isset($fieldRuleList['optionnal'])) {
                $optionnal = $fieldRuleList['optionnal'];
            }
            if ($optionnal === true && $this->data[$field] == '') {
                continue;
            }
            foreach ($fieldRuleList as $ruleType => $ruleData) {
                if ($ruleType !== 'prepare') {
                    $return = array(
                        'name' => $field,
                        'message' => $ruleData['message'],
                        'error' => $ruleType
                    );
                    if ($ruleType == 'different') {
                        $fieldTest = $ruleData['field'];
                        if (!$this->isDifferent($this->data[$field], $fieldTest)) {
                            return $return;
                        }
                    } else if ($ruleType == 'ip') {
                        $type = false;
                        if (isset($ruleData['type'])) {
                            $type = $ruleData['type'];
                        }
                        if (!$this->isIban($this->data[$field], $type)) {
                            return $return;
                        }
                    } else if ($ruleType == 'identical') {
                        $fieldTest = $ruleData['field'];
                        if (!$this->isIdentical($this->data[$field], $fieldTest)) {
                            return $return;
                        }
                    } else if ($ruleType == 'notEmpty') {
                        if (!$this->isNotEmpty($this->data[$field])) {
                            return $return;
                        }
                    } else if ($ruleType == 'passwordStrength') {
                        $digit = false;
                        if (isset($ruleData['digit'])) {
                            $digit = $ruleData['digit'];
                        }
                        $lower = false;
                        if (isset($ruleData['lower'])) {
                            $lower = $ruleData['lower'];
                        }
                        $upper = false;
                        if (isset($ruleData['upper'])) {
                            $upper = $ruleData['upper'];
                        }
                        $symbol = false;
                        if (isset($ruleData['symbol'])) {
                            $symbol = $ruleData['symbol'];
                        }
                        if (!$this->isPasswordStrength($this->data[$field], $digit, $lower, $upper, $symbol)) {
                            return $return;
                        }
                    } else if ($ruleType == 'stringLength') {
                        $min = false;
                        if (isset($ruleData['min'])) {
                            $min = $ruleData['min'];
                        }
                        $max = false;
                        if (isset($ruleData['max'])) {
                            $max = $ruleData['max'];
                        }
                        if (!$this->isStringLength($this->data[$field], $min, $max)) {
                            return $return;
                        }
                    }
                }
            }
        }
        return true;
    }
}
