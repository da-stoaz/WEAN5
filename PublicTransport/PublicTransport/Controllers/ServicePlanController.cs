using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using PublicTransport.Data;
using PublicTransport.Entities;

namespace PublicTransport.Controllers;

[ApiController]
[Route("api/[controller]")]
public class ServicePlanController(AppDbContext context) : ControllerBase
{
    [HttpGet]
    public async Task<ActionResult<List<ServicePlan>>> Get()
    {
        return Ok(await context.ServicePlans.ToListAsync());
    }
    
    [HttpGet("{id}")]
    public async Task<ActionResult<ServicePlan>> Get(int id) // Changed return type to ServicePlan
    {
        // Changed to FirstOrDefaultAsync for a single entity, consistent with other Get(id) patterns
        var servicePlan = await context.ServicePlans.FirstOrDefaultAsync(sp => sp.Id == id);
        if (servicePlan == null)
        {
            return NotFound();
        }
        return Ok(servicePlan);
    }
    
    [HttpPost("{ptId}")]
    public async Task<ActionResult<ServicePlan>> Post(int ptId, ServicePlan servicePlan)
    {
        var publicTransport = await context.PublicTransports.FindAsync(ptId);
        if (publicTransport == null)
            return NotFound();
        
        publicTransport.ServicePlans.Add(servicePlan);
        await context.SaveChangesAsync();
        return Ok(servicePlan);
    }
    
    [HttpPost]
    public async Task<ActionResult<ServicePlan>> PostWithoutId(ServicePlan servicePlan)
    {
        
        context.ServicePlans.Add(servicePlan);
        await context.SaveChangesAsync();
        return Ok(servicePlan);
    }
    
    [HttpPut("{id}")]
    public async Task<ActionResult<ServicePlan>> Put(int id, ServicePlan servicePlan)
    {
        var servicePlanFromDb = await context.ServicePlans.FindAsync(id);
        if (servicePlanFromDb == null)
            return NotFound();
        
        servicePlanFromDb.Type = servicePlan.Type;
        servicePlanFromDb.Duration = servicePlan.Duration;
        // ADDED: Update PublicTransportId
        servicePlanFromDb.PublicTransportId = servicePlan.PublicTransportId; 
        
        await context.SaveChangesAsync();
        return Ok(servicePlanFromDb);
    }
    
    [HttpDelete("{id}")]
    public async Task<ActionResult<ServicePlan>> Delete(int id)
    {
        var servicePlanFromDb = await context.ServicePlans.FindAsync(id);
        if (servicePlanFromDb == null)
            return NotFound();
        context.ServicePlans.Remove(servicePlanFromDb);
        await context.SaveChangesAsync();
        return Ok(servicePlanFromDb);
    }
}