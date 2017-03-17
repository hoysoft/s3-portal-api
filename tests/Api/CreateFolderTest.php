<?php

class CreateFolderTest extends TestCase
{
    /**
     * Testing the user create folder but the bucket is not exist.
     *
     * @return void
     */
    public function testCreateFolderButBucketIsNotExist()
    {
        $user = $this->initUser();
        $token = \JWTAuth::fromUser($user);
        $headers = $this->headers;
        $headers['HTTP_Authorization'] = "Bearer $token";
        $this->post('/api/v1/folder/create', [
            'bucket' => str_random(10),
            'prefix' => str_random(10)
        ], $headers)
        ->seeStatusCode(403)
        ->seeJsonContains([
            "message" => "The bucket is not exist"
        ]);
    }

    /**
     * Testing the user create folder but the folder is exist.
     *
     * @return void
     */
    public function testCreateFolderButFolderIsExist()
    {
        $user = $this->initUser();
        $token = \JWTAuth::fromUser($user);
        $headers = $this->headers;
        $headers['HTTP_Authorization'] = "Bearer $token";
        $bucket = str_random(10);
        $folder = str_random(10);
        $this->createBucket($user, $bucket);
        $this->createFolder($user, $bucket, $folder);
        $this->post('/api/v1/folder/create', [
            'bucket' => $bucket,
            'prefix' => $folder
        ], $headers)
        ->seeStatusCode(403)
        ->seeJsonContains([
            "message" => "The folder is exist"
        ]);
    }

    /**
     * Testing the user create folder is successfully.
     *
     * @return void
     */
    public function testCreateFolderSuccess()
    {
        $user = $this->initUser();
        $token = \JWTAuth::fromUser($user);
        $headers = $this->headers;
        $headers['HTTP_Authorization'] = "Bearer $token";
        $bucket = str_random(10);
        $folder = str_random(10);
        $this->createBucket($user, $bucket);
        $this->post('/api/v1/folder/create', [
            'bucket' => $bucket,
            'prefix' => $folder
        ], $headers)
        ->seeStatusCode(200)
        ->seeJsonContains([
            "message" => "Create folder is Successfully"
        ]);
    }
}
