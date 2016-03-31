var arborRenderer = {
    init:  function(system){ console.log("starting",system) },
    redraw:function(){ console.log("redraw") }
};
var sys = arbor.ParticleSystem();
sys.renderer = arborRenderer;