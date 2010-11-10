/*
---
script: CountDown.js
license: MIT-style license.
description: CountDown - a mootools countdown implementation.
copyright: Copyright (c) 2008 Thierry Bela
authors: [Thierry Bela]

requires: 
  core:1.2.3: 
  - Events
  - Options
provides: [CountDown]
...
*/

	var CountDown = new Class({
		
		
		options: {
	
		/* 
			onChange: $empty,
			onComplete: $empty,
			date: null,
			frequency: 1000, //define the update frequency (in ms), default to 1000
		*/
			
			countdown: true
		},

		Implements: [Options, Events],
		initialize: function (options) {
	
			this.setOptions(options);
			if(!this.options.date instanceof Date) this.options.date = new Date(this.options.date);
			
			this.time = this.options.date.getTime();
			
			this.timer = new PeriodicalExecuter(this[ this.options.countdown ? 'countdown' : 'count'].bind(this), (this.options.frequency || 1000) / 1000);
		},
		stop: function () {
		
			this.timer.stop();			
			return this
		},
		start: function () {
		
			this.timer.registerCallback();			
			return this
		},
		
		calcute: function (from, now) {
					
			var millis = Math.max(0, from - now),
				time = Math.floor(millis / 1000),
				countdown = {
			
					days: Math.floor(time / (60 * 60 * 24)), 
					time: time,
					millis: millis
				};
			
			time %= (60 * 60 * 24);
			
	        countdown.hours = Math.floor(time / (60 * 60));
			time %= (60 * 60);
	        countdown.minutes = Math.floor(time / 60);
	        countdown.second = time % 60;
			
			return countdown
			
		}.protect(),
		
		count: function () {
		
			this.fireEvent('onChange', this.calcute(new Date().getTime(), this.time));
		},
		
		countdown: function () {
		
			var countdown = this.calcute(this.time, new Date().getTime());
			
			this.fireEvent('onChange', countdown);
			
			if(countdown.time == 0) {
			
				this.timer.stop();
				this.fireEvent('onComplete');
			}
		}
	});
	