<?php

require_once 'Models/Dummy.php';
require_once 'DbTestCase.php';

class CommentableTest extends DbTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->migrate(database_path('migrations'));
        $this->migrate(__DIR__ . '/migrations');
    }

    public function testScopeHasComments()
    {
        $dummy = Dummy::create([ 'name' => $this->faker->name ]);

        Dummy::create([ 'name' => $this->faker->name ]);

        $this->createComment($dummy, [], 10);

        $this->assertEquals(1, Dummy::hasComments()
                                    ->count());

        $this->assertArraySubset($dummy->toArray(), Dummy::hasComments()
                                                         ->first()
                                                         ->toArray());
    }

    public function testScopeHasNoComments()
    {
        $dummy = Dummy::create([ 'name' => $this->faker->name ]);

        $dummyNoComments = Dummy::create([ 'name' => $this->faker->name ]);

        $this->createComment($dummy, [], 10);

        $this->assertEquals(1, Dummy::hasNoComments()
                                    ->count());

        $this->assertArraySubset($dummyNoComments->toArray(), Dummy::hasNoComments()
                                                                   ->first()
                                                                   ->toArray());
    }

    public function testScopeHasCommentsByUser()
    {
        $user = $this->createUser();

        $dummy = Dummy::create([ 'name' => $this->faker->name ]);

        $anotherDummy = Dummy::create([ 'name' => $this->faker->name ]);

        $this->createComment($dummy, [ 'user_id' => $user->id ], 10);

        $this->createComment($anotherDummy, [], 10);

        $this->createComment($dummy, [], 10);

        $this->assertEquals(1, Dummy::hasCommentsByUser($user)
                                    ->count());

        $actual = Dummy::hasCommentsByUser($user)
                       ->get();

        $this->assertEquals($dummy->toArray(), $actual->first()->toArray());
    }

    public function testScopeByUser()
    {
        $user1 = $this->createUser();

        $user2 = $this->createUser();

        $dummy = Dummy::create([ 'name' => $this->faker->name ]);

        $expected = $this->createComment($dummy, [ 'user_id' => $user1->id ], 10);

        $this->createComment($dummy, [ 'user_id' => $user2->id ], 10);

        $actual = \Sinclair\Commentable\Models\Comment::byUser($user1)
                                                      ->get();

        $this->assertEquals(10, sizeof($actual));

        foreach ( $expected as $key => $row )
            $this->assertArraySubset($row->toArray(), $actual->get($key)
                                                             ->toArray());
    }

    public function createComment( $object, $attributes = [], $count = 1 )
    {
        $comments = collect();

        for ( $i = 0; $i < $count; $i++ )
            $comments->push(\Sinclair\Commentable\Models\Comment::create([
                'text'             => implode(' ', $this->faker->words),
                'user_id'          => array_get($attributes, 'user_id', $this->createUser()->id),
                'commentable_type' => array_get($attributes, 'commentable_type', get_class($object)),
                'commentable_id'   => array_get($attributes, 'commentable_id', $object->id),
            ]));

        return $comments;
    }

    public function createUser()
    {
        return \App\User::create([
            'name'     => $this->faker->name,
            'email'    => $this->faker->email,
            'password' => $this->faker->password
        ]);
    }
}