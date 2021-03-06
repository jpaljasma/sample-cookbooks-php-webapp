current_release = release_path
Chef::Log.info("running deploy/before_symlink.rb in folder #{current_release}")
Chef::Log.debug(node.to_json)

#create themes directory 
directory "#{current_release}/themes" do
  owner "apache"
  group "deploy"
  mode 0775
  action :create
end

# create production .htaccess file
template "#{current_release}/.htaccess" do
  source "htaccess.erb"
  mode 0644
  group "deploy"
  owner "apache"

  variables(
    :env =>    (node[:appserver][:env] rescue 'production')
  )
end

# run composer installer without dev dependencies
script "install_composer" do
  interpreter "bash"
  user "root"
  cwd current_release
  code <<-EOH
  curl -sS https://getcomposer.org/installer | php
  php composer.phar install --no-dev
  EOH
end
