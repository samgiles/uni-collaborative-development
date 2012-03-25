<?php
abstract class Observer {
	abstract public function update (Observable $subject);
}