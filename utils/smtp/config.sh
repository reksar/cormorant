#!/bin/bash

sasl() {
  postconf -e smtpd_sasl_auth_enable=yes
  postconf -e smtpd_sasl_type=dovecot

  # Use `inet:<host>:<port>` instead of `private/auth` when dovecot is remote.
  # See https://doc.dovecot.org/configuration_manual/howto/postfix_and_dovecot_sasl/
  postconf -e smtpd_sasl_path=inet:imap:$IMAP_AUTH_PORT

  postconf -e smtpd_relay_restrictions="permit_mynetworks \
    permit_sasl_authenticated reject_unauth_destination"
}

vmail_box() {
  local MAILBOX=$POSTFIX_SPOOLDIR/vmail
  postconf -e virtual_mailbox_base=$MAILBOX

  local USER=vmail
  local GROUP=postdrop
  mkdir -p $MAILBOX/$EMAIL_DOMAIN
  chown -R $USER:$GROUP $MAILBOX

  local USER_ID=`id -u $USER`
  postconf -e virtual_minimum_uid=$USER_ID
  postconf -e virtual_uid_maps=static:$USER_ID

  local GROUP_ID=`id -g $USER`
  postconf -e virtual_gid_maps=static:$GROUP_ID
}

vmail_map() {
  # TODO: sync map with imap `passwd`.
  local VMAILBOX=$POSTFIX_MAPDIR/vmailbox
  postconf -e virtual_mailbox_maps=hash:$VMAILBOX

  # Solve permissions problem with the `postmap`.
  chmod 777 $POSTFIX_MAPDIR

  postmap $VMAILBOX
}

vmail() {
  # See http://www.postfix.org/VIRTUAL_README.html
  postconf -e virtual_mailbox_domains=$EMAIL_DOMAIN
  vmail_box
  vmail_map
}

# Enable submission on 587 port.
# See http://www.postfix.org/wip.html about editing `/etc/postfix/master.cf`.
postconf -Me submission/inet='submission inet n - n - - smtpd'

sasl
vmail
