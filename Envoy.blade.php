@servers(['web' => 'deployer@66.97.41.105'])
@setup
$repository = 'git@gitlab.com:santiagopegels/almatulook.git';
$releases_dir = '/var/www/almatulook/releases';
$app_dir = '/var/www/almatulook';
$release = date('YmdHis');
$new_release_dir = $releases_dir .'/'. $release;
$password = 'J5UweJdEfm';//deployer user password
@endsetup
@story('deploy')
clone_repository
run_composer
update_symlinks
@endstory
@task('clone_repository')
echo 'Cloning repository'
[ -d {{ $releases_dir }} ] || mkdir {{ $releases_dir }}
git clone --depth 1 {{ $repository }} {{ $new_release_dir }}
cd {{ $new_release_dir }}
git reset --hard {{ $commit }}
@endtask
@task('run_composer')
echo "Starting deployment ({{ $release }})"
cd {{ $new_release_dir }}
composer install --prefer-dist --no-scripts -q -o
@endtask
@task('update_symlinks')
echo 'Linking current release'
ln -nfs {{ $new_release_dir }} {{ $app_dir }}/current
echo "{{ $password }}" | sudo -S chmod 777 -R {{ $app_dir }}
@endtask
