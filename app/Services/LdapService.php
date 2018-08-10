<?php

namespace App\Services;

use App\Base\Request;
use Adldap\Laravel\Facades\Adldap;

class LdapService {

  const DOMAIN    = 1;
  const SUBDOMAIN = 2;
  const USER      = 3;
  const APP       = 4;
  const REPO      = 5;
  const GROUP     = 6;
  const OU        = 6;

  public $baseDn;
  public $userObjsectClass = [
    'top',
    'person',
    'inetOrgPerson',
    'shadowAccount',
    'posixAccount',
    'posixGroup',
    'mailRecipient',
    'groupOfNames',
    'inetSubscriber',
    'ldapPublicKey'
  ];

  public function __construct() {
    $this->baseDn = config('adldap.connections.default.connection_settings.base_dn');
  }

  public function buildUserEntry(Request $request) {
//    $newUid     = $this->createNewUid();
    $ldapParams = [
      'uid'          => $request->user_name,
      'cn'           => $request->user_name,
      'userPassword' => $request->user_password,
//      'uidNumber'    => $newUid,
//      'gidNumber'    => $newUid
    ];

    if ($request->lastname) {
      $ldapParams['sn'] = $request->lastname;
    }
    if ($request->user_email) {
      $ldapParams['mailForwardingAddresssn'] = $request->user_email;
    }

    if ($request->user_email) {
      $ldapParams['ipHostNumber'] = $request->ip;
    }

    if ($request->user_email) {
      $ldapParams['gecos'] = $request->language;
    }

    $searchUser = Adldap::search()->findByDn($this->buildDN(self::USER, $request->user_name));

    if ($searchUser->exists) {
      $request->errorInternal('Remote user already exists');
    }

    $ldapUser = Adldap::make()->entry($ldapParams);
    $ldapUser->setAttribute('objectclass', $this->userObjsectClass);
    $ldapUser->setDn($this->buildDN(self::USER, $request->user_name));
    $ldapUser->save();
  }

  public function buildDN($type, $param) {
    $dn = '';
    if ($type) {
      switch ($type) {
        case self::SUBDOMAIN:
          $dn = 'dc=' . str_replace('.', ',dc=', $param) . ',';
          break;
        case self::USER:
          $dn = "uid={$param},ou=Users,";
          break;
        case self::GROUP:
          $dn = "cn={$param},ou=Groups,";
          break;
        case self::APP:
          $dn = "cn={$param},ou=Apps,";
          break;
        case self::REPO:
          $dn = "cn={$param},ou=Repos,";
          break;
      }
    }
    $dn .= $this->baseDn;

    return $dn;
  }

  public function createNewUid() {
    $baseDn = Adldap::search()->findByDn($this->baseDn);
//    var_dump($baseDn);exit;
    $newUid = 1;
    if ($baseDn->exists) {
      $newUid            = (int) $baseDn->uidNumber + 1;
      $baseDn->cn = $newUid;
      $baseDn->setAttribute('objectclass', ['top', 'dcObject', 'organization']);
      $baseDn->save();
    }
    return $newUid;
  }

}
