/*
Script: PeriodicalExecuter.js
	port of the Prototype.js timer to Mootools

	License: MIT-style license.
	Copyright: Copyright (c) 2007 Thierry bela <bntfr at yahoo dot fr>

	License:
		MIT-style license.

	Authors:
		Thierry Bela

	TODO: possibility to stop the timer when the window is idle ?
*/			
	var PeriodicalExecuter = new Class({
		// name: 'PeriodicalExecuter',
		initialize: function(callback, frequency) {
		
			this.callback = callback;
			this.frequency = frequency;
			this.currentlyExecuting = false;

			this.registerCallback()
		},

		registerCallback: function() {
		
			this.stop();
			this.timer = setInterval(this.onTimerEvent.bind(this), this.frequency * 1000);
			return this
		},

		execute: function() {
		
			this.callback(this);
			return this
		},

		stop: function() {
		
			if (!this.timer) return this;
			clearInterval(this.timer);
			this.timer = null;
			return this
		},

		onTimerEvent: function() {
		
			if (!this.currentlyExecuting) {
			
				try {
				
					this.currentlyExecuting = true;
					this.execute();
				} finally {
				
					this.currentlyExecuting = false;
				}
			}
				
			return this
		}
	});
