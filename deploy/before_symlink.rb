current_release = release_path
Chef::Log.info("running deploy/before_symlink.rb in folder #{current_release}")
Chef::Log.debug(deploy)
Chef::Log.debug(node)

#create themes directory 
directory "#{current_release}/themes" do
  if platform?("ubuntu")
    owner "www-data"
  elsif platform?("amazon")   
    owner "apache"
  end
  group deploy[:group]
  mode 0775
  action :create
end
  
# create production .htaccess file
template "#{current_release}/.htaccess" do
  source "htaccess.erb"
  mode 0644
  group deploy[:group]
  owner "apache"

  variables(
    :env =>    (node[:metasearch][:env] rescue nil)
  )
end

# create proper folders if not exist
directory "#{current_release}/core/cache" do
  group deploy[:group]
  owner "apache"
  mode 00755
  action :create
end

directory "#{current_release}/core/cache/zend" do
  group deploy[:group]
  owner "apache"
  mode 00755
  action :create
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
