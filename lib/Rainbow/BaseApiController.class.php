<?php
/*
 *
 * Copyright (c) 2010 Nicholas Granado
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 */

class BaseApiController {
	
	public function __contruct() {}
	public function __destruct() {}
	public function __clone()    {}

	public static function RaiseErrorMissingParam($param) {
		$this->service->SetFormat(ContentType::APPLICATION_X_JAVASCRIPT);
		$status_code = 400;
		$this->service->SetStatus($status_code);
		$data = json_encode_pretty(array("error" => "$param parameter is malformed or missing", "status_code" => $status_code . ' ' . $this->service->status_codes[$status_code]));
		$this->service->SendData($data);
	}

	public static function RaiseErrorUnauthorized($param) {
		$this->service->SetFormat(ContentType::APPLICATION_X_JAVASCRIPT);
		$status_code = 401;
		$this->service->SetStatus($status_code);
		$data = json_encode_pretty(array("error" => "$param parameter is invalid", "status_code" => $status_code . ' ' . $this->service->status_codes[$status_code]));
		$this->service->SendData($data);
	}

	public static function RenderJson($data) {
		$this->service->SetFormat(ContentType::APPLICATION_X_JAVASCRIPT);
		$return_value = '';

		if(isset($_GET['formatted'])) {
			$return_value = json_encode_pretty($data);
		} else {
			$return_value = json_encode($data);
		}

		if(isset($_GET['json_callback'])) {
			$json_callback = $_GET['json_callback'];
			$return_value = sprintf("%s(%s);", $json_callback, $return_value);
		}

		$this->service->SendData($return_value);
	}
}