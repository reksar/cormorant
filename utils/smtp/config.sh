#!/bin/bash

# Edit `/etc/postfix/main.cf`.

postconf -e smtpd_sasl_auth_enable=yes
postconf -e smtpd_sasl_type=dovecot

# Use `inet:<host>:<port>` instead of `private/auth` when dovecot is remote.
# See https://doc.dovecot.org/configuration_manual/howto/postfix_and_dovecot_sasl/
postconf -e smtpd_sasl_path=inet:imap:$IMAP_AUTH_PORT

postconf -e smtpd_relay_restrictions="permit_mynetworks \
  permit_sasl_authenticated reject_unauth_destination"


# Edit `/etc/postfix/master.cf`.
# See http://www.postfix.org/wip.html

# Enable submission on 587 port.
postconf -Me submission/inet='submission inet n - n - - smtpd'
