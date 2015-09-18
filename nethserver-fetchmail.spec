%define fetchmail_home /var/lib/nethserver/fetchmail

Name:		nethserver-fetchmail
Version: 1.1.4
Release: 1%{?dist}
Summary:	NethServer fetchmail
Group:		Networking/Daemons
License:	GPLv2
URL:		http://www.nethesis.it
Source0:	%{name}-%{version}.tar.gz
BuildArch: 	noarch

BuildRequires:	nethserver-devtools
Requires:	nethserver-mail-server > 1.8.2-1
Requires:	fetchmail

%description
Fetchmail add-on for NethServer

%prep
%setup

%build
%{makedocs}
perl createlinks

%install
rm -rf $RPM_BUILD_ROOT
(cd root   ; find . -depth -not -name '*.orig' -print  | cpio -dump $RPM_BUILD_ROOT)
%{genfilelist} $RPM_BUILD_ROOT \
    --dir '/var/run/fetchmail' 'attr(0750,fetchmail,root)' \
    --dir '%{fetchmail_home}' 'attr(0750,fetchmail,fetchmail)' \
    > %{name}-%{version}-%{release}-filelist
echo "%doc COPYING" >> %{name}-%{version}-%{release}-filelist

%clean 
rm -rf $RPM_BUILD_ROOT

%pre
if ! getent passwd fetchmail >/dev/null; then
   # Add the "fetchmail" user
   useradd -r -U -s /sbin/nologin -d %{fetchmail_home} -c "Fetchmail user" fetchmail

elif ! [ -d %{fetchmail_home} ]; then
   # Stop any running instance:
   service fetchmail status &>/dev/null && service fetchmail stop
   # Create the primary group, if not exists:
   groupadd -f -g `id -u fetchmail` -r fetchmail
   # Fix the home dir path and move the existing DB to the new path:
   usermod -m -d %{fetchmail_home} -g fetchmail fetchmail
   mkdir -m 0750 %{fetchmail_home}
   mv -n /var/run/fetchmail/.fetchids %{fetchmail_home}/.fetchids &>/dev/null
   chown -Rf fetchmail.fetchmail %{fetchmail_home}
fi

exit 0

%files -f %{name}-%{version}-%{release}-filelist
%defattr(-,root,root)

%changelog
* Fri Sep 18 2015 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 1.1.4-1
- Wrong column in Pop3 Connector view table - Bug #3259

* Tue Jul 28 2015 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 1.1.3-1
- Fetchmail: Add new column in Pop3 Connector view table - Enhancement #3231 [NethServer]

* Mon Jun 22 2015 Davide Principi <davide.principi@nethesis.it> - 1.1.2-1
- Cannot change POP3 connector  poll interval - Bug #3134 [NethServer]

* Fri Dec 12 2014 Davide Principi <davide.principi@nethesis.it> - 1.1.1-2.ns6
- Route message to postfix, for alias expansion. Refs #2978
- Fix shown groups in POP3 connector page
- Partially reverts #2954

* Thu Dec 11 2014 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 1.1.1-1.ns6
- New fixes for - Enhancement #2954 [NethServer]

* Tue Dec 09 2014 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 1.1.0-1.ns6
- Fetchmail re-download all emails after reboot - Bug #2947 [NethServer]
- Fetchmail support for AD users - Enhancement #2924 [NethServer]

* Wed Oct 15 2014 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 1.0.5-1.ns6
- Fetchmail: change UI label - Enhancement #2863

* Thu Jul 03 2014 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 1.0.4-1.ns6
- Delivers to non-existing email addresses - Bug #2766
- Implement migration - Enhancement #2763

* Thu Jun 12 2014 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 1.0.4-1.ns6
- Implement migration - Enhancement #2763

* Mon Mar 10 2014 Davide Principi <davide.principi@nethesis.it> - 1.0.3-1.ns6
- Warning after fetchmail installation - Bug #2677 [NethServer]

* Wed Feb 05 2014 Davide Principi <davide.principi@nethesis.it> - 1.0.2-1.ns6
- Update all inline help documentation - Task #1780 [NethServer]

* Wed Oct 16 2013 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 1.0.1-1.ns6
- Allow email address as username for login  #2183
- Db defaults: remove Runlevels prop #2067

* Tue Apr 30 2013 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 1.0.0-1.ns6
- First release #1745 
