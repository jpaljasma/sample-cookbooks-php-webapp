current_release = release_path
Chef::Log.info("running deploy/before_symlink.rb in folder #{current_release}")
Chef::Log.debug("#{node}")

#run "echo 'release_path: #{release_path}' >> #{shared_path}/logs.log"
#run "echo 'current_path: #{current_path}' >> #{shared_path}/logs.log"
#run "echo 'shared_path: #{shared_path}' >> #{shared_path}/logs.log"
#run "echo 'node: #{node}' >> #{shared_path}/logs.log"

#create themes directory 
directory "#{current_release}/themes" do
  owner "apache"
  group "deploy"
  mode 0775
  action :create
end
  
# create production .htaccess file
#template "#{current_release}/.htaccess" do
#  source "htaccess.erb"
#  mode 0644
#  group "deploy"
#  owner "apache"

#  variables(
#    :env =>    (node[:metasearch][:env] rescue nil)
#  )
#end

# run composer installer without dev dependencies
#script "install_composer" do
#  interpreter "bash"
#  user "root"
#  cwd current_release
#  code <<-EOH
#  curl -sS https://getcomposer.org/installer | php
#  php composer.phar install --no-dev
#  EOH
#end
