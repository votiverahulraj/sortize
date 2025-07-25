pwd
git status
ls -la
whoami
git config --global --add safe.directory /var/www/vhosts/votivereact.in/sortize.votivereact.in
git status
git branch
git remote -v
git add .
git status
ls
ls -la
git status
ssh-keygen -t rsa -b 4096 -C "rahul@votivereact.in" -f ~/.ssh/sortize_id_rsa
eval "$(ssh-agent -s)"
ssh-add ~/.ssh/sortize_id_rsa
cat ~/.ssh/sortize_id_rsa.pub
nano ~/.ssh/config
git remote set-url origin git@github.com:votiverahulraj/sortize.git
ssh -T git@github.com-sortize
chmod 700 /var/www/vhosts/votivereact.in/sortize.votivereact.in/.ssh
chmod 600 /var/www/vhosts/votivereact.in/sortize.votivereact.in/.ssh/config
chmod 600 /var/www/vhosts/votivereact.in/sortize.votivereact.in/.ssh/sortize_id_rsa
chmod 644 /var/www/vhosts/votivereact.in/sortize.votivereact.in/.ssh/sortize_id_rsa.pub
chown -R sortizedeploy:psaserv /var/www/vhosts/votivereact.in/sortize.votivereact.in/.ssh
ssh -T git@github.com-sortize
git remote set-url origin git@github.com-sortize:votiverahulraj/sortize.git
ssh -T git@github.com-sortize
git remote set-url origin https://github.com/votiverahulraj/sortize.git
