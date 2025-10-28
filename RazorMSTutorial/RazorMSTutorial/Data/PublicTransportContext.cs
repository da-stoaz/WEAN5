using Microsoft.EntityFrameworkCore;
using RazorMSTutorial.Models;

namespace RazorMSTutorial.Data;

public class PublicTransportContext : DbContext
{
    public PublicTransportContext(DbContextOptions<PublicTransportContext> options) : base(options)
    {
        
    }
   
    
    public DbSet<PublicTransport> PublicTransports { get; set; }
    public DbSet<ServicePlan> ServicePlans { get; set; }
}