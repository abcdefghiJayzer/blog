<?php
/**
 * Copyright 2016 Facebook, Inc.
 *
 * You are hereby granted a non-exclusive, worldwide, royalty-free license to
 * use, copy, modify, and distribute this software in source code or binary
 * form for use in connection with the web services and APIs provided by
 * Facebook.
 *
 * As with any software that integrates with the Facebook platform, your use
 * of this software is subject to the Facebook Developer Principles and
 * Policies [http://developers.facebook.com/policy/]. This copyright notice
 * shall be included in all copies or substantial portions of the software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 */
namespace Facebook;

use Facebook\Authentication\AccessToken;

class FacebookApp implements \Serializable
{
    protected $id;
    protected $secret;

    public function __construct($id, $secret)
    {
        $this->id = $id;
        $this->secret = $secret;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSecret()
    {
        return $this->secret;
    }

    public function getAccessToken()
    {
        return new AccessToken($this->id . '|' . $this->secret);
    }

    // Modern PHP serialization methods
    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'secret' => $this->secret,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->id = $data['id'];
        $this->secret = $data['secret'];
    }

    // Legacy methods for backward compatibility
    public function serialize()
    {
        return serialize($this->__serialize());
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->__unserialize($data);
    }
}

