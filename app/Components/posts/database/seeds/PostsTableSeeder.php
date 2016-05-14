<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder {

    public function run()
    {
        \DB::table('posts')->delete();

        \DB::table('posts')->insert(array (
            array (
                'id' => '1',
                'title' => 'Contact Us',
                'permalink' => 'contact',
                'image' => NULL,
                'content' => 'Our contact address goes here',
                'status' => 'published',
                'target' => 'public',
                'featured' => '0',
                'publish_start' => NULL,
                'publish_end' => NULL,
                'meta_title' => NULL,
                'meta_description' => NULL,
                'meta_keywords' => NULL,
                'type' => 'page',
                'hits' => '0',
                'extras' => '{"contact_page":true,"contact_coords":"40.7142700, -74.0059700"}',
                'created_by' => '1',
                'updated_by' => NULL,
                'created_at' => '2014-03-29 21:45:00',
                'updated_at' => '2014-03-29 21:45:00',
            ),
            array (
                'id' => '9',
                'title' => 'Welcome',
                'permalink' => 'welcome',
                'image' => NULL,
                'content' => '<p>The CMS public section can now be viewed at <a href="#">Public</a></p>

<p>The CMS admin can now be viewed at <a href="admin">Admin</a></p>

<p>The CMS backend can now be viewed at <a href="backend">Backend</a></p>',
                'status' => 'published',
                'target' => 'public',
                'featured' => '0',
                'publish_start' => NULL,
                'publish_end' => NULL,
                'meta_title' => NULL,
                'meta_description' => NULL,
                'meta_keywords' => NULL,
                'type' => 'page',
                'hits' => '0',
                'extras' => NULL,
                'created_by' => '1',
                'updated_by' => NULL,
                'created_at' => '2014-03-29 21:45:00',
                'updated_at' => '2014-03-29 21:45:00',
            ),
            array (
                'id' => '10',
                'title' => 'About Us',
                'permalink' => 'about-us',
                'image' => NULL,
                'content' => '<p>Doptor is an Integrated and well-designed Content Management System (CMS) provides an end user with the tools to build and maintain a sustainable web presence. For a serious company, having a maintainable website is extremely important and the effectiveness of such a site depends on the ease of use and power of the backend CMS. There are many available CMS out there but they are too generalized to fit the needs of many companies.</p>

<p>Introducing the new CMS platform for businesses, which caters to their exact need without sacrificing the power and quality of a standard platform. Through this CMS, websites can be built that aims to serve as a learning and knowledge-sharing platform for the company and act as communication tool to disseminate information to the internal and external stakeholders. The website will be a tool for sharing public information and build rapport with the external stakeholders. It will be the main channel for the company to publish and share information on activities, lessons learnt from the project interventions, good practices and relevant research. In addition to having a CMS, a business needs other tools for regular operations as well. These other suites of applications run in the different departments of the company but together they ensure the moving forward of the company. In order to assist a company with all these needs, the CMS platform will include additional business modules, for example Invoicing, Bills, Accounting, Payroll, etc.</p>

<p>This CMS compliable with IOS and android, other mobile devices and with all browser.</p>

<p>- Doptor are provide a free opensource CMS.&nbsp;<br />
- Build your website and any kind of application using doptor.<br />
- Both online and offline.</p>

<p>3 type of interface- 1). Backend, 2). Admin, 3). Public</p>

<p>- Backend : You can manage full system.<br />
- Admin : Your officer / clark can do the operation such as accounting, payroll, inventory etc.<br />
- Public : &nbsp;Public website.</p>
',
                'status' => 'published',
                'target' => 'public',
                'featured' => '0',
                'publish_start' => NULL,
                'publish_end' => NULL,
                'meta_title' => NULL,
                'meta_description' => '',
                'meta_keywords' => '',
                'type' => 'page',
                'hits' => '1',
                'extras' => NULL,
                'created_by' => '1',
                'updated_by' => NULL,
                'created_at' => '2014-03-29 21:45:00',
                'updated_at' => '2014-03-31 10:15:26',
            ),
            array (
                'id' => '11',
                'title' => 'First Post',
                'permalink' => 'first-post',
                'image' => NULL,
                'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi odio mauris, auctor ut varius non, tempus nec nisi. Quisque at tellus risus. Aliquam erat volutpat. Proin et dolor magna. Sed vel metus justo. Mauris eu metus massa. Duis viverra ultricies nisl, ut pharetra eros hendrerit non.</p>
<p>Phasellus laoreet libero non eros rhoncus sed iaculis ante molestie. Etiam arcu purus, dictum a tincidunt id, ornare sed orci. Curabitur ornare ornare nulla quis tincidunt. Morbi nisi elit, mattis nec bibendum vel, facilisis eu ipsum. Phasellus non dolor erat, in placerat lacus. Aliquam pulvinar, est eu commodo vulputate, neque elit molestie lorem, sed vestibulum felis erat et risus. Nulla non velit odio.</p>
<p>Curabitur ornare ornare nulla quis tincidunt. Morbi nisi elit, mattis nec bibendum vel, facilisis eu ipsum. Phasellus non dolor erat, in placerat lacus. Aliquam pulvinar, est eu commodo vulputate, neque elit molestie lorem, sed vestibulum felis erat et risus. Nulla non velit odio.</p>',
                'status' => 'published',
                'target' => 'public',
                'featured' => '0',
                'publish_start' => NULL,
                'publish_end' => NULL,
                'meta_title' => NULL,
                'meta_description' => NULL,
                'meta_keywords' => NULL,
                'type' => 'post',
                'hits' => '0',
                'extras' => NULL,
                'created_by' => '1',
                'updated_by' => NULL,
                'created_at' => '2014-03-29 21:45:00',
                'updated_at' => '2014-03-29 21:45:00',
            ),
            array (
                'id' => '12',
                'title' => 'Second Post',
                'permalink' => 'second-post',
                'image' => NULL,
                'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi odio mauris, auctor ut varius non, tempus nec nisi. Quisque at tellus risus. Aliquam erat volutpat. Proin et dolor magna. Sed vel metus justo. Mauris eu metus massa. Duis viverra ultricies nisl, ut pharetra eros hendrerit non.</p>
<p>Phasellus laoreet libero non eros rhoncus sed iaculis ante molestie. Etiam arcu purus, dictum a tincidunt id, ornare sed orci. Curabitur ornare ornare nulla quis tincidunt. Morbi nisi elit, mattis nec bibendum vel, facilisis eu ipsum. Phasellus non dolor erat, in placerat lacus. Aliquam pulvinar, est eu commodo vulputate, neque elit molestie lorem, sed vestibulum felis erat et risus. Nulla non velit odio.</p>
<p>Curabitur ornare ornare nulla quis tincidunt. Morbi nisi elit, mattis nec bibendum vel, facilisis eu ipsum. Phasellus non dolor erat, in placerat lacus. Aliquam pulvinar, est eu commodo vulputate, neque elit molestie lorem, sed vestibulum felis erat et risus. Nulla non velit odio.</p>',
                'status' => 'published',
                'target' => 'public',
                'featured' => '0',
                'publish_start' => NULL,
                'publish_end' => NULL,
                'meta_title' => NULL,
                'meta_description' => NULL,
                'meta_keywords' => NULL,
                'type' => 'post',
                'hits' => '0',
                'extras' => NULL,
                'created_by' => '1',
                'updated_by' => NULL,
                'created_at' => '2014-03-29 21:45:00',
                'updated_at' => '2014-03-29 21:45:00',
            ),
            array (
                'id' => '13',
                'title' => 'Help',
                'permalink' => 'help',
                'image' => NULL,
                'content' => '<p>How to create accounting module :&nbsp;<br />
4 steps for create any kind of module such as accounting, payroll, inventory etc. (we are keepon increase controller for form builder). Now 5%-10% programming (coding) required. Coming soon 0% coding.<br />
&nbsp;<br />
Step -1 : Create one or two form (Builder--&gt;Form Builder), all field name must be unique.&nbsp;<br />
Step -2 : Create a module (Builder --&gt; Module Builder) and select which form you are using.&nbsp;<br />
Step -3 : Install Module. go to Extension --&gt; module --&gt; Install<br />
Step -4 : Create Menu (Menu manager) must assign module.<br />
&nbsp;<br />
Thanks<br />
And Enjoy.</p>

<p>&nbsp;</p>
',
                'status' => 'published',
                'target' => 'public',
                'featured' => '0',
                'publish_start' => NULL,
                'publish_end' => NULL,
                'meta_title' => NULL,
                'meta_description' => '',
                'meta_keywords' => '',
                'type' => 'page',
                'hits' => '0',
                'extras' => NULL,
                'created_by' => '1',
                'updated_by' => NULL,
                'created_at' => date('Y-m-d h:i:s', time()),
                'updated_at' => date('Y-m-d h:i:s', time()),
            ),
        ));
    }

}
