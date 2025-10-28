using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using PublicTransport.Data;

namespace PublicTransport.Controllers;

[ApiController]
[Route("api/[controller]")]
public class PublicTransportController(AppDbContext context) : ControllerBase
{
    [HttpGet]
    public async Task<ActionResult<List<Entities.PublicTransportE>>> Get()
    {
        return Ok(await context.PublicTransports.Include(pt => pt.ServicePlans).ToListAsync());
    }
    
    [HttpGet("{id}")]
    public async Task<ActionResult<Entities.PublicTransportE>> Get(int id)
    {
        return Ok(await context.PublicTransports.Include(pt => pt.ServicePlans).FirstOrDefaultAsync(p => p.Id == id));
    }
    
    [HttpPost]
    public async Task<ActionResult<Entities.PublicTransportE>> Post(Entities.PublicTransportE publicTransportE)
    {
        await context.PublicTransports.AddAsync(publicTransportE);
        await context.SaveChangesAsync();
        return Ok(publicTransportE);
    }
    
    [HttpPut("{id}")]
    public async Task<ActionResult<Entities.PublicTransportE>> Put(int id, Entities.PublicTransportE publicTransportE)
    {
        var publicTransportFromDb = await context.PublicTransports.FindAsync(id);
        if (publicTransportFromDb == null)
            return NotFound();
        
        publicTransportFromDb.TransportType = publicTransportE.TransportType;
        publicTransportFromDb.IsEnabled = publicTransportE.IsEnabled;
        publicTransportFromDb.HoursSinceLastService = publicTransportE.HoursSinceLastService;
        await context.SaveChangesAsync();
        return Ok(publicTransportFromDb);
    }
    
    [HttpDelete("{id}")]
    public async Task<ActionResult<Entities.PublicTransportE>> Delete(int id)
    {
        var publicTransportFromDb = await context.PublicTransports.FindAsync(id);
        if (publicTransportFromDb == null)
            return NotFound();
        context.PublicTransports.Remove(publicTransportFromDb);
        await context.SaveChangesAsync();
        return NoContent();
    }
}