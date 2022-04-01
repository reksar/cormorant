#!/bin/bash

postconf -e smtpd_sasl_auth_enable=yes
postconf -e smtpd_sasl_type=dovecot

# Use `inet:<host>:<port>` instead of `private/auth` when dovecot is remote.
# See https://doc.dovecot.org/configuration_manual/howto/postfix_and_dovecot_sasl/
# TODO: sync port with IMAP service automatically.
postconf -e smtpd_sasl_path=inet:imap:12345

postconf -e smtpd_relay_restrictions="permit_mynetworks \
    permit_sasl_authenticated reject_unauth_destination"
