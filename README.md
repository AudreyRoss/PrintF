#	PrintF
Creators: Audrey Ross, Yee Wai, Lorena Villa
------------------------------------------------------------------------
#What PrintF Does
PrintF, the Wordpress Layout Engine project, is a child theme supported by a plugin. A child theme is a wordpress theme that inherits the properties of a “parent” theme but allows changes to the layout without permanently changing the parent. Our child theme will modify the layout so that it is similar to that of a newspaper. The plugin uses wordpress taxonomies to allow an editor to categorize stories. The plugin automatically translates the posts into a proper layout.
PrintF creates various layouts based on the news stories and the level of importance the website administrator indicates for each story.  
  
It uses taxonomies to have site editor categorize the posts. Next PrintF separates the posts as indicated by the web administrator into: Breaking stories, Top stories (later separate into with and without pictures), Featured stories, Regular stories, and stories not displayed on the homepage. It will then take the last x posts from the last y days. Both x and y are set by user in the PrintF Settings on the wordpress site dashboard. Based on the number of posts in each of these groups PrintF will automatically generate an appropriate layout.

------------------------------------------------------------------------
#Installing and Configuring PrintF

##Plugin
1.  Go to the dashboard of your wordpress site
2.  Under “Plugins” in the side menu 
3.  Go to “Add New”
4.  Upload the PrintF plugin folder
5.  Under “Plugins” in the side menu 
6.  Go to “Installed Plugins”
7.  Find the PrintF in the list of Plugins
8.  Click Activate 

##Child Theme
1.  Go to the dashboard of your wordpress site
2.  Under “Appearance” in the side menu 
3.  Go to “Themes”
4.  Choose the “Install Themes” tab
5.  Upload the PrintF child theme folder
6.  Switch to the “Manage Themes” tab
7.  Find the PrintF under “Available themes”
8.  Click  Activate

------------------------------------------------------------------------
#Using PrintF


Notice that there is now a "Story Category" box on the side when you are adding or editing a post. In this box there is a drop down menu with the options "Breaking", "Top", "Featured", "Regular", and "Not Displayed". Using this dropdown menu, label each of the posts. The label with determine where they appear on the homepage.

Notice that there is a "PrintF Settings" option in the Dashboard menu. 
Here the user sets various other options that will affect the layout of the homepage, such as number of each type of story to display.

Also, there is a "Printf: Featured" widget that the user can now add to the sidebar of their homepage. I can be found in the dashboard under Appearance -> Widgets->Available widgets. It must be moved into the Main Sidebar (drag and drop) to be displayed. 

