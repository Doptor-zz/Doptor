<?php

class PostsTableSeeder extends \Seeder {

    public function run()
    {
        // Uncomment the below to wipe the table clean before populating
        DB::table('posts')->delete();

        $posts = array(
            array(
                'title'      => 'Contact Us',
                'permalink'  => 'contact',
                'content'    => '',
                'status'     => 'published',
                'type'       => 'page',
                'target'     => 'public',
                'created_by' => 1,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d')
            )
        );

        // Uncomment the below to run the seeder
        DB::table('posts')->insert($posts);
    }

}
