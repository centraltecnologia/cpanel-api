<?php namespace Codemax\cPanelPHP;

/**
 * Trait CpanelShortcuts
 *
 * @package Codemax\CpanelWhm
 */
trait CpanelShortcuts
{
    /******************************************************************************
     * WHM Accounts
     ******************************************************************************/

    /**
     * Lista todas as contas de uma Revenda ou Root
     *
     * @return mixed
     */
    public function listAccounts()
    {
        return $this->runQuery('listaccts', []);
    }

    /**
     * Cria uma nova conta
     *
     * @param $domain_name
     * @param $username
     * @param $password
     * @param $plan
     *
     * @return mixed
     */
    public function createAccount($domain_name, $username, $password, $plan, $reseller = 0)
    {
        return $this->runQuery('createacct', [
            'username' => $username,
            'domain' => $domain_name,
            'password' => $password,
            'plan' => $plan,
            'reseller' => $reseller
        ]);
    }

    /**
     * Deletar uma conta permantemente do WHM (não reversivel)
     *
     * @param string $username
     */
    public function destroyAccount($username)
    {
        return $this->runQuery('removeacct', [
            'user' => $username,
        ]);
    }

    /**
     * Reativa um conta que estava suspensa
     *
     * @param $username
     * @return mixed
     */
    public function unsuspendAccount($username)
    {
        return $this->runQuery('unsuspendacct', [
            'user' => $username,
        ]);
    }

    /**
     * Mostra detalhes de recursos de uma conta
     *
     * @param $username
     * @return mixed
     */
    public function detailsAccount($username)
    {
        return $this->runQuery('accountsummary', [
            'user' => $username,
        ]);
    }

    /**
     * Lista todas as contas suspensas e a razão de estar suspensa
     * @return mixed
     */
    public function listSuspended()
    {
        return $this->runQuery('listsuspended', []);
    }

    /**
     * Essa função suspende uma conta
     *
     * @param $username
     * @return mixed
     */
    public function suspendAccount($username, $reason = '')
    {
        return $this->runQuery('suspendacct', [
            'user' => $username,
            'reason' => $reason,
        ]);
    }

    /******************************************************************************
     * WHM Packages
     ******************************************************************************/

    /**
     * Essa função faz Upgrade/Downgrade de uma conta no WHM
     *
     * @param $username
     * @param $pkg
     * @return mixed
     */
    public function changePackage($username, $pkg)
    {
        return $this->runQuery('changepackage', [
            'user' => $username,
            'pkg' => $this->getUsername().'_'.$pkg
        ]);
    }

    /**
     * Lista todos os pacotes cadastrados no WHM
     *
     * @return mixed
     */
    public function listPackages()
    {
        return $this->runQuery('listpkgs', []);
    }

    /**
     * Adiciona um Plano de Hospedagem no WHM
     *
     * @param $name
     * @param $params
     * @return mixed
     */
    public function addPackage($name, $params)
    {
        return $this->runQuery('addpkg', [
            'name' => $name,
            'quota' => $params['disk_limit'],
            'ip' => $params['ip'], // y | n - Para permitir IP Dedicado
            'cgi' => $params['cgi'], // 1 - Enabled | 0 - Disabled
            'frontpage' => $params['frontpage'], // 1 - Enabled | 0 - Disabled
            'cpmod' => $params['theme'], // paper_latern, x3
            'language' => 'pt_br',
            'maxpop' => $params['mails'],
            'maxaddon' => $params['domains'],
            'bwlimit' => $params['bw_limit'],
            'maxpark' => $params['domains_park'],
            'maxsql' => $params['sql_limit'],
            'maxftp' => 'unlimited',
            'maxlists' => 'unlimited',
            'maxsub' => 'unlimited'
        ]);
    }

    /**
     * Edita um Plano no WHM
     *
     * @param $name
     * @param $params
     * @return mixed
     */
    public function editPackage($name, $params)
    {
        return $this->runQuery('editpkg', [
            'name' => $name,
            'quota' => $params['disk_limit'],
            'ip' => $params['ip'], // y | n - Para permitir IP Dedicado
            'cgi' => $params['cgi'], // 1 - Enabled | 0 - Disabled
            'frontpage' => $params['frontpage'], // 1 - Enabled | 0 - Disabled
            'cpmod' => $params['theme'], // paper_latern, x3
            'language' => 'pt_br',
            'maxpop' => $params['mails'],
            'maxaddon' => $params['domains'],
            'bwlimit' => $params['bw_limit'],
            'maxpark' => $params['domains_park'],
            'maxsql' => $params['sql_limit'],
            'maxftp' => 'unlimited',
            'maxlists' => 'unlimited',
            'maxsub' => 'unlimited'
        ]);
    }

    /**
     * Deleta um Plano no WHM
     *
     * @param $pkg
     * @return mixed
     */
    public function deletePackage($pkg)
    {
        return $this->runQuery('killpkg', [
            'pkg' => $this->getUsername().'_'.$pkg,
        ]);
    }

    /**
     * Lista todas as contas de revenda no WHM
     *
     * @return mixed
     */
    public function listResellers()
    {
        return $this->runQuery('listresellers', []);
    }

    /******************************************************************************************
     * END WHM Functions
     */

    /**
     * Gets the email addresses that exist under a cPanel account
     *
     * @param $username
     */
    public function listEmailAccounts($username)
    {
        return $this->cpanel('Email', 'listpops', $username);
    }

    /**
     * @param $username **cPanel username**
     * @param $email email address to add
     * @param $password password **for the email address**
     * @return mixed
     * @throws \Exception
     */
    public function addEmailAccount($username, $email, $password)
    {
        list($account, $domain) = $this->split_email($email);

        return $this->emailAction('addpop', $username, $password, $domain, $account);
    }

    /**
     * Change the password for an email account in cPanel
     *
     * @param $username
     * @param $email
     * @param $password
     * @return mixed
     * @throws \Exception
     */
    public function changeEmailPassword($username, $email, $password)
    {
        list($account, $domain) = $this->split_email($email);

        return $this->emailAction('passwdpop', $username, $password, $domain, $account);
    }

    /**
     * Runs a blank API Request to pull cPanel's response.
     *
     * @return array [status (0 is fail, 1 is success), error (internal error code), verbose (Extended error message)]
     */
    public function checkConnection()
    {
        try {
            $this->runQuery('', [], true);
        } catch (\Exception $e) {
            if ($e->hasResponse()) {
                switch ($e->getResponse()->getStatusCode()) {
                    case 403:
                        return json_encode([
                            'status' => 0,
                            'error' => 'auth_error',
                            'verbose' => 'Check Username and Password/Access Key.'
                        ]);
                    default:
                        return json_encode([
                            'status' => 0,
                            'error' => 'unknown',
                            'verbose' => 'An unknown error has occurred. Server replied with: ' . $e->getResponse()->getStatusCode()
                        ]);
                }
            } else {
                return json_encode([
                    'status' => 0,
                    'error' => 'conn_error',
                    'verbose' => 'Check CSF or hostname/port.'
                ]);
            }
            return false;
        }

        return json_encode([
            'status' => 1,
            'error' => false,
            'verbose' => 'Everything is working.'
        ]);
    }

    /**
     * Split an email address into two items, username and host.
     *
     * @param $email
     * @return array
     * @throws \Exception
     */
    private function split_email($email)
    {
        $email_parts = explode('@', $email);
        if (count($email_parts) !== 2) {
            throw new \Exception("Email account is not valid.");
        }

        return $email_parts;
    }

    /**
     * Perform an email action
     *
     * @param $action
     * @param $username
     * @param $password
     * @param $domain
     * @param $account
     * @return mixed
     */
    private function emailAction($action, $username, $password, $domain, $account)
    {
        return $this->cpanel('Email', $action, $username, [
            'domain' => $domain,
            'email' => $account,
            'password' => $password,
        ]);
    }
}
